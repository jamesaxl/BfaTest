<?php

namespace App\Http\DataGrids;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

abstract class QueryDataGrid
{

    /**
     * Data resource.
     *
     * @var
     */
    protected $resource;

    /**
     * QueryDataGrid Request object.
     */
    public $request;

    /**
     * Builder object.
     *
     * @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * QueryDataGrid Columns.
     *
     * @var array
     */
    protected $columns;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Get the request
        $this->request = app('datagrid.request');

        // Get the query
        $query = app()->call([$this, 'query']);
        if ($query instanceof EloquentBuilder || $query instanceof Builder) {
            $this->builder = $query;
        } else {
            //It's a model maybe !
            $this->builder = $query->getQuery();
        }

        // Register columns
        $this->columns();
    }

    /**
     * Add new column.
     *
     * @param $name
     * @param $data
     * @param bool $isSortable
     * @param bool $isFilterable
     * @param bool $isSearchable
     *
     * @return QueryDataGrid
     */
    protected function column($name, $data = null, $isSortable = false, $isFilterable = false, $isSearchable = false)
    {
        $this->columns[$name] = func_get_args();

        return $this;
    }

    /**
     * Columns Definition.
     */
    abstract protected function columns();

    /**
     * Get the query object.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    //abstract public function query();

    /**
     * @param $filters
     * @param $query
     * @param string $boolean
     *
     * @return mixed
     */
    public function applyFilters($filters, $query, $boolean = 'and',$additionalFiltersToSkip = [])
    {
        foreach ($filters as $filter) {
            if ('and' == $filter || 'or' == $filter) {
                $nextBoolean = $filter;
                continue;
            }

            // Get the first element
            $first = $filter[0];

            // if Array contains element X Continue
            if(in_array($first, $additionalFiltersToSkip))
                continue;

            //

            if (is_string($first)) { // Binary filter
                $this->applySingleFilter($query, $filter[0], $filter[1], $filter[2], $nextBoolean ?? $boolean);
            } elseif ('!' == $first) { // Unary filter
                $this->applySingleFilter(
                    $query,
                    $filter[1][0],
                    $filter[1][1],
                    $filter[1][2],
                    $nextBoolean ?? $boolean,
                    true
                );
            } elseif (is_array($first)) { // Complex filter
                $query->addNestedWhereQuery(
                    $this->applyFilters($filter, $query->forNestedWhere()),
                    $nextBoolean ?? $boolean
                );
            }

            $nextBoolean = null;
        }

        return $query;
    }

    /**
     * Apply single filter to query.
     *
     * @param $query
     * @param $field
     * @param $operator
     * @param $value
     * @param bool   $unary
     * @param string $boolean
     */
    protected function applySingleFilter($query, $field, $operator, $value, $boolean = 'and', $unary = false)
    {
        list($operator, $value) = $this->compileFilterOperator($operator, $value, $unary);

        $query->where(
            $this->compileColumn($field),
            $operator,
            $value,
            $boolean
        );
    }

    /**
     * Compile single operator.
     *
     * @param $operator
     * @param $value
     * @param $unary
     *
     * @return array
     */
    protected function compileFilterOperator($operator, $value, $unary)
    {
        static $operators = [
            // Operator => [DB Operator, Reverse DB operator, DB Value]
            '=' => ['=', '!=', '#value#'],
            '<>' => ['<>', '=', '#value#'],
            '>' => ['>', '<=', '#value#'],
            '>=' => ['>=', '<', '#value#'],
            '<' => ['<', '>=', '#value#'],
            '<=' => ['<=', '>', '#value#'],
            'startswith' => ['LIKE', 'NOT LIKE', '#value#%'],
            'endswith' => ['LIKE', 'NOT LIKE', '%#value#'],
            'contains' => ['LIKE', 'NOT LIKE', '%#value#%'],
            'notcontains' => ['NOT LIKE', 'LIKE', '%#value:#%'],
        ];

        return [
            !$unary ? $operators[$operator][0] : $operators[$operator][1],
            str_replace('#value#', $value, $operators[$operator][2]),
        ];
    }

    /**
     * Apply sorting.
     *
     * @param $sorts
     */
    protected function applySorts($sorts)
    {
        foreach ($sorts as $sort) {
            $this->builder->orderBy($this->compileColumn($sort['selector']), $sort['desc'] ? 'desc' : 'asc');
        }
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    private function compileColumn($name)
    {
        return $this->columns[$name][1] ?? $name;
    }

    /**
     * Get the base query builder instance.
     *
     * @param mixed $instance
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getBaseQueryBuilder($instance = null)
    {
        if (!$instance) {
            $instance = $this->builder;
        }
        if ($instance instanceof EloquentBuilder) {
            return $instance->getQuery();
        }

        return $instance;
    }

    /**
     * Complete actions on a large number of selected items.
     */
    protected function handleBulkAction()
    {
        $bulk = $this->request->input('bulk');

        //Check bulk params
        if (!$bulk || !is_array($bulk) || !isset($bulk['name']) || !is_array($bulk['ids']) || !count($bulk['ids'])) {
            return;
        }

        //Call Method
        $method = 'bulk'.studly_case($bulk['name']);
        if (method_exists($this, $method)) {
            $this->$method($bulk['ids']);
        }
    }

    /**
     * @param $resourceClass
     * @param array $additional
     *
     * @return mixed
     */
    protected function makeResource($resourceClass, $additional = [])
    {
        if ($resourceClass) {
            return (new AnonymousResourceCollection($this->builder->get(), $resourceClass))->additional($additional);
        }

        return (new AnonymousResourceCollection($this->builder->get(), $this->resource))->additional($additional);
    }

    /**
     * Rendering resource.
     *
     * @param null $resourceClass
     *
     * @return mixed
     */
    public function resource($resourceClass = null)
    {
        // Additional resource data
        $additional = [];

        // Handle Bulk request
        if ($this->request->hasBulkAction()) {
            $this->handleBulkAction();
        }

        // Apply filters
        if ($this->request->isFilterable()) {
            $this->applyFilters($this->request->filters(), $this->getBaseQueryBuilder());
        }

        //Require total count
        if ($this->request->requireTotalCount()) {
            $additional['totalCount'] = $this->getBaseQueryBuilder()->count();
        }

        // Apply sorting

        if ($this->request->isSortable()) {
            //dd($this->request->sort);
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
