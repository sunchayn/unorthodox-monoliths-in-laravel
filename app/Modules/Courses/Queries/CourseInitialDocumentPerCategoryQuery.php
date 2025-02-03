<?php

namespace App\Modules\Courses\Queries;

use App\Modules\Courses\Models\Course;
use App\Modules\Documents\Models\Document;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * @phpstan-type RawDocumentMetadata object{id: int, published_at: string, category_id: int, popularity_score: double}
 */
class CourseInitialDocumentPerCategoryQuery
{
    public const PER_PAGE = 3;

    private readonly int $totalPerCategory;

    public function __construct(
        private readonly Course $course,
        private readonly int $perPage = self::PER_PAGE,
    ) {
        $this->totalPerCategory = $this->perPage * 2;  // Load two pages per category

        $this->course->loadMissing([
            // '...',
        ]);
    }

    /**
     * @return Collection<int, array{items: EloquentCollection<array-key, Document>, metadta: array{...}}>
     */
    public function get(): Collection
    {
        $metadata = $this->getMetadataPerCategory();

        $documentsById = $this
            ->loadDocumentsFromids(
                ids: $metadata->flatMap->items->pluck('id')->all(),
            )
            ->keyBy('id');

        $documents = $this->metadataToPaginatedCategories($metadata, $documentsById);

        $this->eagerLoadRequiredRelations($documents);

        return $documents;
    }

    /**
     * @return Collection<int, array{total: int, items: Collection<int, RawDocumentMetadata>}>
     */
    private function getMetadataPerCategory(): Collection
    {
        return Document::query()
            ->select('id', 'category_id', 'popularity_score', 'published_at')
            ->where('course_id', $this->course->id)
            ->whereNotNull('published_at')
            ->toBase() // <- Avoids Eloquent hydration
            ->get() // <- Fetches ALL assigned documents for the course
            ->groupBy('category_id')
            ->map(fn (Collection $documents): array => [
                'total' => $documents->count(),
                'items' => $this->rearrangeDocumentsOnPages($documents),
            ]);
    }

    /**
     * @param  Collection<int, RawDocumentMetadata>  $documentsMetadata
     * @return Collection<int, RawDocumentMetadata>
     */
    private function rearrangeDocumentsOnPages(Collection $documentsMetadata): Collection
    {
        return $documentsMetadata
            ->sortBy([
                ['popularity_score', 'desc'],
                ['published_at', 'desc'],
                ['id', 'desc'],
            ])
            ->take($this->totalPerCategory);  // Keep only two pages worth of documents
    }

    private function loadDocumentsFromIds(array $ids): Collection
    {
        return Document::query()
            ->select([
                'documents.id',
                'documents.title',
                'documents.published_at',
                'documents.category_id',
                'documents.popularity_score',
            ])
            ->whereIntegerInRaw('id', $ids)
            ->get();
    }

    /**
     * @return Collection<int, array{items: EloquentCollection<array-key, Document>, metadta: array{...}}>
     */
    private function metadataToPaginatedCategories(Collection $metadata, Collection $documentsById): Collection
    {
        return $metadata
            ->map(fn (array $categoryMetadata) => [
                'items' => EloquentCollection::make(
                    $categoryMetadata['items']
                        ->map(fn (object $rawDocumentObject): Document => $documentsById->get($rawDocumentObject->id))
                        ->values(),
                ),
                'metadata' => [
                    'total' => $categoryMetadata['total'],
                    'per_page' => $this->perPage,
                     'current_page' => min(2, max((int) ceil($categoryMetadata['total'] / $this->perPage), 1)),
                     'last_page' => max((int) ceil($categoryMetadata['total'] / $this->perPage), 1),
                  ],
              ]);

    }

    /**
     * @param  Collection<int, Document>  $documentsPerCategory
     */
    private function eagerLoadRequiredRelations(Collection $documentsPerCategory): void
    {
        $documents = EloquentCollection::make($documentsPerCategory->pluck('items')->collapse());

        $documents
            ->each(fn (Document $document) => $document->course()->associate($this->course))
            ->loadMissing([
                // ...
            ]);
    }
}
