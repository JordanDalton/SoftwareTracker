<?php namespace Acme\Storage\Interfaces;

interface MachineRepositoryInterface {

    /** 
     * Search for resources that match a user-supplied criteria.
     * 
     * @param  string $criteria The user-supplied search criteria.
     * @param  array  $with     Relationship data to eager-load.
     * @param  int    $perPage  The numbers of records to appear on eage page.
     * @param  array  $columns  The colums of data you want returned.
     * @return Illuminate\Pagination\Paginator
     */
    public function searchPaginated( $criteria, $with = [], $perPage = 15, $columns = ['*'] );

}