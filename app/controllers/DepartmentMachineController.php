<?php

use Acme\Storage\Interfaces\DepartmentRepositoryInterface;
use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Validation\DepartmentMachineValidator;

class DepartmentMachineController extends \BaseController {

    /** 
     * The department repository implementation.
     * 
     * @var Acme\Storage\Repositories\DepartmentRepository
     */
    protected $departments;

    /** 
     * The machine repository implementation.
     * 
     * @var Acme\Storage\Repositories\MachineRepository
     */
    protected $machines;

    /** 
     * The department machine validator.
     * 
     * @var Acme\Validation\DepartmentMachineValidator
     */
    protected $validator;

    /** 
     * Create new DepartmentController instance.
     * 
     * @param DepartmentRepositoryInterface $departments
     * @param DepartmentValidator           $validator
     */
    public function __construct( 
        DepartmentRepositoryInterface $departments, 
        MachineRepositoryInterface $machines, 
        DepartmentMachineValidator $validator 
    ){
        $this->departments = $departments;
        $this->machines    = $machines;
        $this->validator   = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        // Fetch the department record.
        // 
        $department = $this->departments->findById( $id );

        // Fetch all machines of the department.
        // 
        $machines = $department->machines()->paginate();

        // Show the page.
        // 
        return View::make('departments.machines.index', compact('department', 'machines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        // Fetch the department record.
        // 
        $department = $this->departments->findById( $id );

        // Determine which machines are already assigned to the department.
        // 
        $existingIds = array_map( function( $record ) {
            return $record['id'];
        }, $department->machines->toArray());

        // Fetch all available machines from the database.
        // 
        $machines = $this->machines->all( ['department'] );

        // Define array that will contain the machines that will be appearing
        // in the machine dropdown list.
        // 
        $machines_dropdown = [];

        // Loop through each machine record and add it to the $machines_dropdown array.
        // 
        foreach ( $machines as $machine )
        {
            // Prepare the label for the dropdown item.
            // 
            $label = sprintf( '%s (%s)', $machine->mac_address, $machine->rarp() );

            // Append record to the $machines_dropdown array.
            // 
            $machines_dropdown[ $machine->id ] = $label;
        }

        // Filter out the machines that already have the machine insalled on it.
        // 
        $machines_dropdown = array_except( $machines_dropdown , $existingIds );

        // Show the page.
        // 
        return View::make('departments.machines.create', compact('department', 'machines_dropdown'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store( $id )
    {
        // Capture the submitted form data.
        // 
        $input = Input::except('_token');

        // Fetch the department record from the database.
        // 
        $department = $this->departments->findById( $id );

        // Fetch the machine record from the database.
        // 
        $machine = $this->machines->findById( $input['machine_id'] );

        // The submitted data failed to pass validation.
        // 
        if ( ! $this->validator->validate( $input ))
        {
            // Capture the validation error message(s).
            // 
            $errors = $this->validator->errors();

            // Go back to the form.
            // 
            return Redirect::back()->withInput()->withErrors( $errors );
        }

        //-------------------------------
        // Input passed validation.
        //-------------------------------

        // Attach the machine record to the department.
        // 
        $machine->department_id = $department->id;
        $machine->save();

        // Successful machine assigned record message.
        // 
        $message = sprintf( 
            '<strong>%s</strong> machine was successfully assigned to <strong>%s</strong>.', 
            $machine->mac_address,
            $department->name
        );

        // Send the user back to the department machine list page and display a message
        // that communicate a machine was attach to the department.
        // 
        return Redirect::route('departments.machines.index', $department->id)->withMachineAttached( $message );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Fetch the department record from the database.
        // 
        $department = $this->departments->findById( $id );

        // Show the page.
        // 
        return View::make('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}