<?php

use Acme\Storage\Interfaces\PublisherRepositoryInterface;

class PublisherTableSeeder extends Seeder {

    /** 
     * The publisher repository implementation.
     * 
     * @var Acme\Storage\Repositories\PublisherRepository
     */
    protected $publishers;

    /** 
     * Create new PublisherTableSeeder instance.
     * 
     * @param PublisherRepositoryInterface $publishers
     */
    public function __construct( PublisherRepositoryInterface $publishers )
    {
        $this->publishers = $publishers;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Flush out all records from the table.
        // 
        $this->publishers->getModel()->truncate();

        // Define the default data we want dumped into the table.
        // 
        $data = ['Not Specified'];

        // Now insert data if needed.
        // 
        for( $i = 0, $size = count($data); $i < $size; $i++ )
        {
            $this->publishers->create(['name' => $data[$i]]);
        }
    }

}