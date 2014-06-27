<?php namespace Acme\Storage\Traits;

trait Repository {

    /** 
     * Fetch all resources from the database.
     *
     * @param  array  $with    Relationship data to eager-load.
     * @param  array  $columns The colums of data you want returned.
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all( $with = [], $columns = ['*'] )
    {
        return $this->model->with( $with )->get( $columns );
    }

    /** 
     * Fetch all resources from the database in paginated form.
     *
     * @param  array  $with    Relationship data to eager-load.
     * @param  int    $perPage The numbers of records to appear on eage page.
     * @param  array  $columns The colums of data you want returned.
     * @return Illuminate\Pagination\Paginator
     */
    public function allPaginated( $with = [], $perPage = 15, $columns = ['*'] )
    {
        return $this->model->with( $with )->paginate( $perPage, $columns );
    }

    /**
     * Display the specified resource by it's ID number.
     *
     * @param  int    $id
     * @param  array  $with    Relationship data to eager-load.
     * @param  array  $columns The colums of data you want returned.
     * @return Response
     */
    public function findById( $id, $with = [], $columns = ['*'] )
    {
        return $this->model->with( $with )->find( $id, $columns );
    }

    /** 
     * Store a newly created resource in storage.
     * 
     * @param  array  $data 
     * @param  string $orAction The action we want to happend if the record already exists.
     * @return Model
     */
    public function create( $data = [] , $orAction = 'create' )
    {
        // Conert $orAction to lowercase.
        // 
        $orAction = strtolower( $orAction );

        // Now capitalize the first letter.
        // 
        $orAction = ucfirst( $orAction );

        // Now exceute and return data.
        // 
        return $this->model->{"firstOr$orAction"}( $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return 
     */
    public function delete( $id )
    {
        return $this->findById( $id )->delete();
    }

    /** 
     * Obtain the model.
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model->getModel();
    }

    /** 
     * Create new resource instance.
     *
     * @param  array $data
     * @return Model
     */
    public function instance( $data = [] )
    {
        return new $this->model( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param  array  $array The data you want applied to the record.
     * @return Response
     */
    public function update( $id, $data = [] )
    {
        // Find the resource record.
        // 
        $record = $this->findById( $id );

        // Assign the changes that are to be made to the record.
        // 
        $record->fill( $data );

        // Save the changes.
        // 
        $record->save();

        // Now return the record.
        // 
        return $record;
    }
}