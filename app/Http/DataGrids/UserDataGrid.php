<?php


namespace App\Http\DataGrids;

use App\Http\DataGrids\QueryDataGrid;
use App\Http\Resources\User\UserResource;
use App\Model\Role;
use App\User;
use App\Model\AccountType;
use Illuminate\Http\Request;

class UserDataGrid extends QueryDataGrid
{
    protected $resource = UserResource::class;

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
            ->column('account_type')
            ->column('account_sub_type')
            ->column('sectors')
            ->column('sub_sectors')
            ->column('language')
            ->column('job_title')
            ->column('mobile_phone')
            ->column('whatsapp')
            ->column('home_phone')
            ->column('fax')
            ->column('email')
            ->column('personal_email')
            ->column('address')
            ->column('postal_code')
            ->column('website')
            ->column('biography')
            ->column('cv')
            ->column('is_enabled')
            ->column('qualifications')
            ->column('city')
            ->column('role')
            ->column('is_focal')
            ->column('is_logistician')
            ->column('is_expert');
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
        if (auth()->usre()->accountType->name != 'bfa') {
            return User::query()->with('country', 'role',
                'userSectors.sector', 'accountType',
                'userSubSectors.subSector',
                'accountSubType',
                'organization',
                'userQualifications.qualification')
                ->where('organization_id', auth()->usre()->organization_id)->orderByDesc('created_at');
        }

        if ($this->request->expert == 'true')
            return User::with('country', 'role',
                'userSectors.sector', 'accountType',
                'userSubSectors.subSector',
                'accountSubType',
                'organization',
                'userQualifications.qualification')
                ->where('is_expert', true)->orderByDesc('created_at');

        if ($this->request->focal == 'true')
            return User::with('country', 'role',
                'userSectors.sector', 'accountType',
                'userSubSectors.subSector',
                'accountSubType',
                'organization',
                'userQualifications.qualification')
                ->where('is_focal', true)->orderByDesc('created_at');

        if ($this->request->logistician == 'true')
            return User::with('country', 'role',
                'userSectors.sector', 'accountType',
                'userSubSectors.subSector',
                'accountSubType',
                'organization',
                'userQualifications.qualification')
                ->where('is_logistician', true)->orderByDesc('created_at');

        $account_type = AccountType::where('name', $this->request->account_type)->first();
        if (!$account_type)
            return User::query()->where('id', 0);

        return User::with('country', 'role',
                        'userSectors.sector', 'accountType',
                        'userSubSectors.subSector',
                        'accountSubType',
                        'organization',
                        'userQualifications.qualification')
            ->where('account_type_id', $account_type->id)->orderByDesc('created_at');
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
