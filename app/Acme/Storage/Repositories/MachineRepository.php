<?php namespace Acme\Storage\Repositories;

use Acme\Machine;
use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Storage\Traits\Repository;

class MachineRepository implements MachineRepositoryInterface {

    use Repository;

    /** 
     * Create new MachineRepository instance.
     * 
     * @param Machine $machines
     */
    public function __construct( Machine $machines )
    {
        $this->model = $machines;
    }

    /** 
     * Search for resources that match a user-supplied criteria.
     * 
     * @param  string $criteria The user-supplied search criteria.
     * @param  array  $with     Relationship data to eager-load.
     * @param  int    $perPage  The numbers of records to appear on eage page.
     * @param  array  $columns  The colums of data you want returned.
     * @return Illuminate\Pagination\Paginator
     */
    public function searchPaginated( $criteria, $with = [], $perPage = 15, $columns = ['*'] )
    {
        return $this->model->with( $with )->where(function( $query ) use ( $criteria )
        {
            // Trim any whitespace around the criteria.
            $criteria = trim( $criteria );

            // Now apply the search filters.
            $query->where('mac_address', 'like', "%$criteria%");
            $query->orWhere('user', 'like', "%$criteria%");
            
        })->paginate($perPage, $columns);
    }
}