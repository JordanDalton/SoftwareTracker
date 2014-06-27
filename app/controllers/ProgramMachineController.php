<?php

use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Storage\Interfaces\ProgramRepositoryInterface;
use Acme\Validation\MachineProgramValidator;

class ProgramMachineController extends \BaseController {

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
	 * The machine program validator.
	 * 
	 * @var Acme\Validation\MachineProgramValidator
	 */
	protected $validator;

	/** 
	 * Create enw MachineProgramController instance.
	 *
	 * @param MachineRepositoryInterface $machines
	 * @param ProgramRepositoryInterface $programs
	 * @param MachineProgramValidator    $validator
	 */
	public function __construct(
		MachineRepositoryInterface $machines,
		ProgramRepositoryInterface $programs,
		MachineProgramValidator    $validator
	){
		$this->machines  = $machines;
		$this->programs  = $programs;
		$this->validator = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($programId)
	{
		// Fetch the program record.
		// 
		$program = $this->programs->findById( $programId );

		// Fetch all machines that the program was installed in.
		// 
		$machines = $program->machines()->paginate();

		// Show the page.
		// 
		return View::make('programs.machines.index', compact('program', 'machines'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($programId)
	{
		// Fetch the program record from the database.
		// 
		$program = $this->programs->findById( $programId , ['machines']);

		// Fetch the list of machines this program is already installed on.
		// 
		$exitingIds = array_map(function($machine){
			return $machine['id'];
		}, $program->machines->toArray());

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
			// Determine what label we will use for the department.
			// 
			$department = isSet($machine->department->name) ? $machine->department->name : 'N/A';

			// Set the label that is to appear in the dropdown.
			// 
			$label = sprintf('%s (%s in %s)', $machine->mac_address, $machine->user, $department);

			// Append data to the $machines_dropdown array.
			// 
			$machines_dropdown[ $machine->id ] = $label;
		}

		// Filter out machines that already have the program installed on it.
		// 
		$machines_dropdown = array_except($machines_dropdown, $exitingIds);

		// Show the page.
		// 
		return View::make('programs.machines.create', compact('program', 'machines_dropdown'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($programId)
	{
		// Capture the submitted form data.
		// 
		$input = Input::except('_token');

		// Fetch the program record from the database.
		// 
		$program = $this->programs->findById( $programId );

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

		// Attach the machine record to the program.
		// 
		$program->machines()->attach( $machine->id );

		// Successful program record message.
		// 
		$message = sprintf( 
			'<strong>%s</strong> program was successfully assigned to <strong>%s</strong>.', 
			$machine->mac_address,
			$program->name
		);

		// Send the user back to the program program list page and display a message
		// that communicate a program was attach to the program.
		// 
		return Redirect::route('programs.machines.index', $program->id)->withMachineAttached( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($programId, $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($programId, $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($programId, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($programId, $id)
	{
		//
	}

}