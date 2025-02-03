<?php

namespace Database\Factories;

use App\Modules\Courses\Models\Course;
use App\Modules\Documents\Enums\CategoryId;
use App\Modules\Documents\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'published_at' => fake()->dateTime(),
            'category_id' => Arr::random(CategoryId::cases()),
            'course_id' => Course::factory(),
            'popularity_score' => fake()->randomFloat(max: 1),
        ];
    }
}
