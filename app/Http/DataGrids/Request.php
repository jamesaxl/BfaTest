<?php

namespace App\Http\DataGrids;


class Request
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = app('request');
    }

    /**
     * Proxy non existing method calls to request class.
     *
     * @param mixed $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->request, $name)) {
            return call_user_func_array([$this->request, $name], $arguments);
        }
    }

    /**
     * Get attributes from request instance.
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->request->__get($name);
    }

    /**
     * Check if QueryDataGrid sorting is enabled.
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->request->has('sort')
            && is_array($this->request->input('sort'))
            && count($this->request->input('sort')) > 0;
    }

    /**
     * Check if QueryDataGrid filtering is enabled.
     *
     * @return bool
     */
    public function isFilterable()
    {
        return $this->request->has('filter')
            && is_array($this->request->input('filter'))
            && count($this->request->input('filter')) > 0;
    }

    /**
     * Indicates that a total count of data objects in the result set must be returned in the totalCount field of the result.
     * This count must reflect the number of data items after filtering, but disregard any take parameter used for the query.
     */
    public function requireTotalCount()
    {
        return $this->request->has('requireTotalCount');
    }

    /**
     * Return the filters array
     *
     * @return bool
     */
    public function filters()
    {
        $filters = $this->request->input('filter');
        return is_array($filters[0]) ? $filters : [$filters];
    }

    /**
     * Return the filters array
     *
     * @return bool
     */
    public function sorts()
    {
        return $this->request->input('sort');
    }

    /**
     * Skips some data objects from the start of the result set. In conjunction with take, this parameter is used to implement paging.
     * @return bool
     */
    public function hasSkip()
    {
        return $this->request->has('skip');
    }

    /**
     * Return the number of data objects to skip from the start of the result set
     */
    public function skip()
    {
        return $this->request->input('skip');
    }

    /**
     * Restricts the number of top-level data objects to return.
     * @return bool
     */
    public function hasTake()
    {
        return $this->request->has('take');
    }

    /**
     * Return the number of top-level data objects to return.
     */
    public function take()
    {
        return $this->request->input('take');
    }

    /**
     * Restricts the number of top-level data objects to return.
     * @return bool
     */
    public function hasBulkAction()
    {
        return $this->request->has('bulk');
    }
}
