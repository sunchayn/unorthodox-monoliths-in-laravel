<?php

namespace App\Http\Monolith;

use App\Modules\Courses\DataTransferObjects\CategoryPaginatedDocuments;
use App\Modules\Courses\Models\Course;
use App\Modules\Courses\Queries\CourseInitialDocumentPerCategoryQuery;
use App\Modules\Documents\Enums\CategoryId;
use App\Modules\Documents\Models\Document;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QueryController
{
    public function __invoke(Request $request): View
    {
        $course = Course::query()->firstOr(callback: fn () => $this->seedInitialCourseAndDocuments());

        $query = new CourseInitialDocumentPerCategoryQuery($course);

        dump('==='.PHP_EOL.'Executed Queries'.PHP_EOL.'===');

        DB::listen(function (QueryExecuted $query) {
            if (Str::startsWith($query->sql, 'explain')) {
                return;
            }

            dump(
                'Query => '.$query->toRawSql()
                 .PHP_EOL.
                'Explain => '.DB::select('explain '.$query->sql)[2]->p4,
            );
        });

        $results = $query
            ->get()
            ->map(function (array $categoryPaginatedDocuments) {
                return [
                    'items' => $categoryPaginatedDocuments['items']->toArray(),
                    'metadata' => $categoryPaginatedDocuments['metadata'],
                ];
            });

        dump('==='.PHP_EOL.'Results'.PHP_EOL.'===');

        dd(
            $results,
        );
    }

    private function seedInitialCourseAndDocuments(): Course
    {
        $courses = Course::factory()->count(5)->create();

        $courses->each(
            fn (Course $course) => Document::factory()
                ->state(fn () => ['category_id' => Arr::random(CategoryId::cases())])
                ->for($course)
                ->count(rand(20, 30))
                ->create(),
        );

        return $courses->first();
    }
}
