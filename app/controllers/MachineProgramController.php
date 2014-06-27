<?php

use Acme\Storage\Interfaces\MachineRepositoryInterface;
use Acme\Storage\Interfaces\ProgramRepositoryInterface;
use Acme\Validation\MachineProgramValidator;

class MachineProgramController extends \BaseController {

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
	public function index($machineId)
	{
		// Fetch the machine record.
		// 
		$machine = $this->machines->findById( $machineId );

		// Fetch all programs that are installed on the machine.
		// 
		$programs = $machine->programs()->paginate();

		// Show the page
		// 
		return View::make('machines.programs.index', compact('machine', 'programs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($machineId)
	{
		// Fetch the machine record from the database.
		// 
		$machine = $this->machines->findById( $machineId , ['programs']);

		// Determine which machines already have the program installed on it.
		// 
		$existingIds = array_map( function( $record ) {
			return $record['id'];
		}, $machine->programs->toArray());

		// Fetch all available programs from the database.
		// 
		$programs = $this->programs->all( ['publisher'] );

		// Define array that will contain the programs that will be appearing
		// in the program dropdown list.
		// 
		$programs_dropdown = [];

		// Loop through each program record and add it to the $programs_dropdown array.
		// 
		foreach ( $programs as $program )
		{
			// Prepare the label for the dropdown item.
			// 
			$label = sprintf( '%s (%s)', $program->name, $program->publisher->name );

			// Append record to the $programs_dropdown array.
			// 
			$programs_dropdown[ $program->id ] = $label;
		}

		// Filter out the machines that already have the program insalled on it.
		// 
		$programs_dropdown = array_except( $programs_dropdown , $existingIds );

		// Show the page.
		// 
		return View::make('machines.programs.create', compact('machine', 'programs_dropdown'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store( $machineId )
	{
		// Capture the submitted form data.
		// 
		$input = Input::except('_token');

		// Fetch the machine record from the database.
		// 
		$machine = $this->machines->findById( $machineId );

		// Fetch the program record from the database.
		// 
		$program = $this->programs->findById( $input['program_id'] );

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

		// Attach the program record to the machine.
		// 
		$machine->programs()->attach( $program->id );

		// Successful machine record message.
		// 
		$message = sprintf( 
			'<strong>%s</strong> program was successfully assigned to <strong>%s</strong>.', 
			$program->name,
			$machine->mac_address
		);

		// Send the user back to the machine program list page and display a message
		// that communicate a program was attach to the machine.
		// 
		return Redirect::route('machines.programs.index', $machine->id)->withProgramAttached( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($machineId, $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($machineId, $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($machineId, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($machineId, $id)
	{
		// Fetch the machine record from the database.
		// 
		$machine = $this->machines->findById( $machineId );

		// Fetch the program record from the database.
		// 
		$program = $this->programs->findById( $id );

		// Detach the program record from the machine.
		// 
		$machine->programs()->detach( $program->id );

		// Successful machine record message.
		// 
		$message = sprintf( 
			'<strong>%s</strong> was detached from <strong>%s</strong>.', 
			$program->name,
			$machine->mac_address
		);

		// Send the user back to the machine program list page and display a message
		// that communicate a program was attach to the machine.
		// 
		return Redirect::back()->withProgramDetached( $message );
	}

}