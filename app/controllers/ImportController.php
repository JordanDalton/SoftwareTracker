<?php

use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Storage\Interfaces\ProgramRepositoryInterface;
use Acme\Storage\Interfaces\PublisherRepositoryInterface;

class ImportController extends \BaseController {
    
    /** 
     * The machine repository implementation.
     * 
     * @var Acme\Storage\Repositories\MachineRepository
     */
    protected $machines;

    /** 
     * The program repository implementation.
     * 
     * @var Acme\Storage\Repositories\ProgramRepository
     */
    protected $programs;

    /** 
     * The publisher repository implementation.
     * 
     * @var Acme\Storage\Repositories\PublisherRepository
     */
    protected $publishers;

    /** 
     * Create new ImportController instance.
     * 
     * @param MachineRepositoryInterface $machines
     * @param ProgramRepositoryInterface $programs
     * @param PublisherRepositoryInterface $publishers
     */
    public function __construct( 
        MachineRepositoryInterface $machines,
        ProgramRepositoryInterface $programs,
        PublisherRepositoryInterface $publishers
    ){
        $this->machines   = $machines;
        $this->programs   = $programs;
        $this->publishers = $publishers;

        set_time_limit(120);
    }

    public function index()
    {
        // Path to the computers folder that contains .txt files for each computer in AD.
        // 
        $computersFolder = sprintf('%s\computers', powershell_path());

        // Now fetch all files in the $computer_folder.
        // 
        $computers = File::files( $computersFolder );

        // Now iterate through the $computers array.
        // 
        foreach( $computers as $computer )
        {
            // Check if the file is a .txt file
            // 
            $isTextFile = File::extension( $computer ) === 'txt';

            // Skip this iteration if the file is not a .txt file.
            // 
            if( ! $isTextFile ) continue;

            // Obtain the computer name form the file.
            // 
            $computerName = basename( $computer , '.txt' );
 
            // Read the file.
            // 
            $file = File::get( $computer );

            // Convert the file to an array that's delimited at each new line.
            // 
            $lines = explode( "\n" , $file );

            // Let's skip to the 4th array element.
            // 
            $lines = array_slice( $lines, 3 );

            // Now loop through each line in the document.
            // 
            foreach( $lines as $line )
            {
                // Remove any strange characters from the string.
                // 
                $line = remove_strange_characters( $line );

                // Now trim any padding from the $line.
                // 
                $line = trim( $line );

                // Now split the line into an array upon each group of spaces.
                // 
                $line = preg_split( '/\s{2,}/' , $line );

                // If no computer name is set then skip the iteration.
                // 
                if( ! isSet( $line[2] )) continue;

                // The 3rd array element must mach the computer name. If it doesn't we
                // will skip the iteration.
                // 
                if( ! ( $line[2] === $computerName )) continue;

                // Bail if no mac address is found for the machine
                // 
                if( ! isSet( $line[3] ))
                {
                    // Log the problem.
                    // 
                    Log::info( sprintf( "%s does not have a MAC address", $computerName ) );

                    // Now skip this iteration.
                    // 
                    continue;
                }

                $publisher_name = $line[0];
                $program_name   = $line[1];
                $computer_name  = $line[2];
                $mac_address    = format_mac_address( $line[3] );

                // Create or fetch the machine record that maches the mac addresss.
                // 
                $machine = $this->machines->create(['mac_address' => $mac_address]);

                // Create new instance or fetch the program record that maches the mac addresss.
                // 
                $program = $this->programs->create(['name' => $program_name], 'new');

                // Create or fetch the publisher record that maches the mac addresss.
                // 
                $publisher = $this->publishers->create(['name' => $publisher_name]);

                // Relate the program to the publisher.
                // 
                $publisher->programs()->save( $program )->machines()->sync( [$machine->id] , false );
            }
            
        }
    }
}