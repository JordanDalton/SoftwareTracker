<?php namespace Acme\Storage\Repositories;

use Acme\Program;
use Acme\Storage\Interfaces\ProgramRepositoryInterface;
use Acme\Storage\Traits\Repository;

class ProgramRepository implements ProgramRepositoryInterface {

    use Repository;

    /** 
     * Create new ProgramRepository instance.
     * 
     * @param Program $programs
     */
    public function __construct( Program $programs )
    {
        $this->model = $programs;
    }
}