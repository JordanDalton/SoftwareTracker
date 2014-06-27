<?php

use Acme\Storage\Interfaces\DepartmentRepositoryInterface;

class DepartmentTableSeeder extends Seeder {

    /** 
     * The department repository implementation.
     * 
     * @var Acme\Storage\Repositories\DepartmentRepository
     */
    protected $departments;

    /** 
     * Create new DepartmentTableSeeder instance.
     * 
     * @param DepartmentRepositoryInterface $departments
     */
    public function __construct( DepartmentRepositoryInterface $departments )
    {
        $this->departments = $departments;
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
        $this->departments->getModel()->truncate();

        // Define the default data we want dumped into the table.
        // 
        $data = ['Not Specified'];

        // Now insert data if needed.
        // 
        for( $i = 0, $size = count($data); $i < $size; $i++ )
        {
            $this->departments->create(['name' => $data[$i]]);
        }
    }

}