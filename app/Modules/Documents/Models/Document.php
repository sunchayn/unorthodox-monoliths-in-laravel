<?php

namespace App\Modules\Documents\Models;

use App\Modules\Courses\Models\Course;
use App\Modules\Documents\Enums\CategoryId;
use Database\Factories\DocumentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    public static string $factory = DocumentFactory::class;

    protected $casts = [
        'published_at' => 'datetime',
        'category_id' => CategoryId::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
