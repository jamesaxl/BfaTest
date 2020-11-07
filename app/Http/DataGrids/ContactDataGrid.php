<?php


namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\Contact\ContactResource;
use App\Model\Role;
use App\Model\Contact;
use Illuminate\Http\Request;

class ContactDataGrid extends QueryDataGrid
{
    protected $resource = ContactResource::class;

    /**
     * Columns Definition.
     */
    protected function columns()
    {
        $this->column('id')
            ->column('photo_path')
            ->column('abv_gender')
            ->column('politeness_formula')
            ->column('name')
            ->column('first_name')
            ->column('last_name')
            ->column('gender')
            ->column('country')
            ->column('nationality')
            ->column('company')
            ->column('account_type')
            ->column('account_sub_type')
            ->column('sectors')
            ->column('qualifications')
            ->column('language')
            ->column('job_title')
            ->column('mobile_phone')
            ->column('whatsapp')
            ->column('home_phone')
            ->column('fax')
            ->column('email')
            ->column('personal_email')
            ->column('address')
            ->column('city')
            ->column('postal_code')
            ->column('website')
            ->column('cv')
            ->column('biography')
            ->column('status')
            ->column('valid');
    }

    /**
     * Get the query object.
     *
     * @param UserQuery $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Contact::with('country', 'nationality',
                             'accountType', 'accountSubType',
                             'city', 'sectors', 'qualifications')->orderByDesc('created_at');
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
