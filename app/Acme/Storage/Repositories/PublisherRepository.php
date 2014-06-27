<?php namespace Acme\Storage\Repositories;

use Acme\Publisher;
use Acme\Storage\Interfaces\PublisherRepositoryInterface;
use Acme\Storage\Traits\Repository;

class PublisherRepository implements PublisherRepositoryInterface {

    use Repository;

    /** 
     * Create new PublisherRepository instance.
     * 
     * @param Publisher $publishers
     */
    public function __construct( Publisher $publishers )
    {
        $this->model = $publishers;
    }
}