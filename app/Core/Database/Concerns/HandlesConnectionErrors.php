<?php

namespace App\Core\Database\Concerns;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @mixin Connection
 */
trait HandlesConnectionErrors
{
    /**
     * @return array<int, mixed>
     *
     * @throws QueryException
     */
    public function select($query, $bindings = [], $useReadPdo = true): array
    {
        try {
            return parent::select($query, $bindings, $useReadPdo);
        } catch (QueryException $exception) {
            if (! app()->isProduction()) {
                throw $exception;
            }

            if ($this->isMissingTableError($exception)) {
                return $this->failGracefully($exception);
            }

            throw $exception;
        }
    }

    private function isMissingTableError(QueryException $exception): bool
    {
        /**
         * For MySQL, we can rely on the server error.
         *
         * @see https://dev.mysql.com/doc/mysql-errors/8.0/en/server-error-reference.html
         */
        $hasServerError = in_array(
            $exception->errorInfo[1] ?? null,
            [
                1051, // Bad table
                1146, // No such table
                1109, // Unknown table
                1356,  // Invalid View or view permission issue
            ],
        );

        if ($hasServerError) {
            return true;
        }

        $message = $exception->errorInfo[2] ?? 'undefined';

        if (Str::startsWith($message, 'no such table')) {
            return true;
        }

        return false;
    }

    private function failGracefully(QueryException $exception): array
    {
        $this->sendAnIncident(
            title: 'A table was not readable',
            originalError: $exception->getMessage(),
        );

        Log::info('A table was not readable', context: [
            'sql' => $exception->getSql(),
            'error' => $exception->getMessage(),
        ]);

        return [];
    }

    private function sendAnIncident(
        string $title,
        string $originalError,
    ): void {
        // Send the error to an incident management platform (PagerDuty, FireHydrant, etc.) if applicable.
    }
}
