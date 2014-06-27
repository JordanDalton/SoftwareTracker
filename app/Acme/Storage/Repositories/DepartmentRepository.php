<?php namespace Acme\Storage\Repositories;

use Acme\Department;
use Acme\Storage\Interfaces\DepartmentRepositoryInterface;
use Acme\Storage\Traits\Repository;

class DepartmentRepository implements DepartmentRepositoryInterface {

    use Repository;

    /** 
     * Create new DepartmentRepository instance.
     * 
     * @param Department $departments
     */
    public function __construct( Department $departments )
    {
        $this->model = $departments;
    }
}