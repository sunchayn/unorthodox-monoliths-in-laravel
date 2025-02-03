<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RestApiHandler extends Handler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     */
    public function render($request, Throwable $e)
    {
        // This is a simple example,
        // You might have different rendering strategies per exception type
        // e.g. validation exceptions, authorization, etc.
        return new JsonResponse(
            [
                'error' => $this->convertExceptionToArray($e),
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
