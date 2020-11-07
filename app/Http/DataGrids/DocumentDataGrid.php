<?php


namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Document\DocumentResource;
use App\Model\Document;
use Illuminate\Http\Request;

class DocumentDataGrid extends QueryDataGrid
{
    protected $resource = DocumentResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
             ->column('title')
             ->column('reference')
             ->column('institution')
             ->column('document_path')
             ->column('document_type')
             ->column('document_sub_type')
             ->column('country')
             ->column('sector')
             ->column('sub_sector')
             ->column('key_words')
             ->column('file')
             ->column('file_transcript');
    }

    /**
     * Get the query object.
     *
     * @param UserQuery $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query(Request $request)
    {
        return Document::with('country', 'sector', 'subSector',
            'documentType', 'documentSubType')->orderByDesc('created_at');
    }

    /**
     * User of bulk action handling.
     *
     * @param $ids
     */
    public function bulkDelete($ids)
    {
    }

    public function resource($resourceClass = null)
    {
        $additional = [];

        // Handle Bulk request
        if ($this->request->hasBulkAction()) {
            $this->handleBulkAction();
        }

        // Apply filters
        if ($this->request->isFilterable()) {
            $this->applyFilters($this->request->filters(), $this->getBaseQueryBuilder());
        }

        // Require total count
        $additional['totalCount'] = $this->getBaseQueryBuilder()->count();

        // Apply sorting
        if ($this->request->isSortable()) {
            $this->applySorts($this->request->sorts());
        }

        // Apply skip
        if ($this->request->hasSkip()) {
            $this->builder->skip($this->request->skip());
        }

        // Apply take
        if ($this->request->hasTake()) {
            $this->builder->take($this->request->take());
        }

        return $this->makeResource($resourceClass, $additional);
    }
}
