<?php

use Acme\Storage\Interfaces\DepartmentRepositoryInterface;
use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Validation\MachineValidator;

class MachineController extends \BaseController {

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
	 * The machine validator.
	 * 
	 * @var Acme\Validation\MachineValidator
	 */
	protected $validator;

	/** 
	 * Create new MachineController instance.
	 * 
	 * @param DepartmentRepositoryInterface $departments
	 * @param MachineRepositoryInterface    $machines
	 * @param MachineValidator              $validator
	 */
	public function __construct( 
		DepartmentRepositoryInterface $departments, 
		MachineRepositoryInterface $machines, 
		MachineValidator $validator 
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
	public function index()
	{
		// Determine if a search criteria was supplied.
		// 
		$search_criteria = Input::query('criteria', false);

		// Fetch machines from the database.
		// 
		$machines = ( $search_criteria ) 
				  ? $this->machines->searchPaginated( $search_criteria, ['programs'] ) 
				  : $this->machines->allPaginated( ['programs'] );

		// Show the page and pass $machines into the view.
		// 
		return View::make('machines.index', compact('machines'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Create new Machine instance.
		// 
		$machine = $this->machines->instance();

		// Fetch all departments from the database.
		// 
		$departments = $this->departments->all([], ['id', 'name']);

		// Define array that will contain the departments that will be appearing
		// in the department dropdown list.
		// 
		$departments_dropdown = [];

		// Loop through each department record and add it to the $departments_dropdown array.
		// 
		foreach ( $departments as $department )
		{
			$departments_dropdown[ $department->id ] = $department->name;
		}

		// Show the page.
		// 
		return View::make('machines.create', compact('departments_dropdown', 'machine'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Capture the submitted form data.
		// 
		$input = Input::except('_token');

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

		// Create a new machine record.
		// 
		$machine = $this->machines->create( $input );

		// Successful machine record message.
		// 
		$message = sprintf( '<strong>%s</strong> was successfully added.' , $machine->mac_address );

		// Send the user back to the machine list page and display a message
		// that communicate a new machine record was created.
		// 
		return Redirect::route('machines.index')->withMachineAdded( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// For now we will automatically redirect to the machine's
		// intalled programs list.
		// 
		return Redirect::route('machines.programs.index', $id);

		// Fetch the machine record.
		// 
		$machine = $this->machines->findById( $id );

		// Fetch all software that was installed on the machine.
		// 
		$programs = $machine->programs()->paginate();

		// Show the page.
		// 
		return View::make('machines.show', compact('programs', 'machine'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Fetch the machine record from the database.
		// 
		$machine = $this->machines->findById( $id, ['department'] );

		// Fetch all departments from the database.
		// 
		$departments = $this->departments->all([], ['id', 'name']);

		// Define array that will contain the departments that will be appearing
		// in the department dropdown list.
		// 
		$departments_dropdown = [];

		// Loop through each department record and add it to the $departments_dropdown array.
		// 
		foreach ( $departments as $department )
		{
			$departments_dropdown[ $department->id ] = $department->name;
		}

		// Determin if the department is set.
		// 
		$department_id = isSet($machine->department) ? $machine->department->id : null;

		// Determine if we should pre-select a department.
		// 
		$department_preselect = Input::query('department', $department_id );

		// Show the page.
		// 
		return View::make('machines.edit', compact('departments_dropdown', 'department_preselect', 'machine'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Fetch the machine record.
		// 
		$machine = $this->machines->findById( $id );

		// Capture the submitted form data.
		// 
		$input = Input::except('_token');

		// The submitted data failed to pass validation.
		// 
		if ( ! $this->validator->validateUpdate( $id, $input ))
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

		// Update the machine record.
		// 
		$machine = $this->machines->update( $id, $input );

		// Successful machine record message.
		// 
		$message = 'Machine was successful updated.';

		// Send the user back to the machine list page and display a message
		// that communicate a new machine record was updated.
		// 
		return Redirect::route('machines.index')->withMachineUpdated( $message );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Fetch the machine record from the database.
		// 
		$machine = $this->machines->findById( $id );

		// Detach all machines from the machine.
		// 
		$machine->programs()->detach();

		// Soft-delete the resource from storage.
		// 
		$this->machines->delete( $id );

		// Successful machine record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> machine was successfully removed.' , $machine->name );

		// Send the user back to the page they were at and display a message
		// that communicate a new machine record was deleted.
		// 
		return Redirect::back()->withMachineDeleted( $message );
	}

}