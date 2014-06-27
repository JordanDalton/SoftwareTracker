<?php

use Acme\Storage\Interfaces\ProgramRepositoryInterface;
use Acme\Storage\Interfaces\PublisherRepositoryInterface;
use Acme\Validation\ProgramValidator;

class ProgramController extends \BaseController {

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
	 protected $publisers;

	/** 
	 * The program validator.
	 * 
	 * @var Acme\Validation\ProgramValidator
	 */
	protected $validator;

	/**
	 * Create new ProgramController instance.
	 * 
	 * @param ProgramRepositoryInterface   $programs   
	 * @param PublisherRepositoryInterface $publishers 
	 * @param ProgramValidator             $validator  
	 */
	public function __construct( 
		ProgramRepositoryInterface $programs, 
		PublisherRepositoryInterface $publishers, 
		ProgramValidator $validator 
	){
		$this->programs   = $programs;
		$this->publishers = $publishers;
		$this->validator = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Fetch all programs from the database.
		// 
		$programs = $this->programs->allPaginated( ['publisher', 'machines'] );

		// Show the page.
		// 
		return View::make('programs.index', compact('programs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Create new program instance.
		// 
		$program = $this->programs->instance();

		// Fetch all publishers from the database.
		// 
		$publishers = $this->publishers->all();

		// Define array that will contain the publishers that will be appearing
		// in the publisher dropdown list.
		// 
		$publishers_dropdown = [];

		// Loop through each publisher record and add it to the $publishers_dropdown array.
		// 
		foreach ( $publishers as $publisher )
		{
			$publishers_dropdown[ $publisher->id ] = $publisher->name;
		}

		// Check if a publisher is to be pre-selected.
		// 
		$publisher_preselect = Input::query('publisher', null);

		// Show the page.
		// 
		return View::make('programs.create', compact('program', 'publishers_dropdown', 'publisher_preselect'));
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

		// Create a new program record.
		// 
		$program = $this->programs->create( $input );

		// Successful program record message.
		// 
		$message = sprintf( '<strong>%s</strong> was successfully added.' , $program->name );

		// Send the user back to the program list page and display a message
		// that communicate a new program record was created.
		// 
		return Redirect::route('programs.index')->withProgramAdded( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Fetch the program record.
		// 
		$program = $this->programs->findById( $id );

		// Fetch all machines that have the program installed on them.
		// 
		$machines = $program->machines()->with(['department'])->paginate();

		// Show the page.
		// 
		return View::make('programs.show', compact('machines', 'program'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Fetch the program record.
		// 
		$program = $this->programs->findById( $id );

		// Fetch all publishers from the database.
		// 
		$publishers = $this->publishers->all();

		// Define array that will contain the publishers that will be appearing
		// in the publisher dropdown list.
		// 
		$publishers_dropdown = [];

		// Loop through each publisher record and add it to the $publishers_dropdown array.
		// 
		foreach ( $publishers as $publisher )
		{
			$publishers_dropdown[ $publisher->id ] = $publisher->name;
		}

		// Show the page.
		// 
		return View::make('programs.edit', compact('program', 'publishers_dropdown'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Fetch the program record.
		// 
		$program = $this->programs->findById( $id );

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

		// Update the program record.
		// 
		$program = $this->programs->update( $id, $input );

		// Successful program record message.
		// 
		$message = sprintf( '<strong>%s</strong> was successfully updated.' , $program->name );

		// Send the user back to the program list page and display a message
		// that communicate a new program record was updated.
		// 
		return Redirect::route('programs.index')->withProgramUpdated( $message );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Fetch the program record from the database.
		// 
		$program = $this->programs->findById( $id );

		// Detach all machines from the program.
		// 
		$program->machines()->detach();

		// Soft-delete the resource from storage.
		// 
		$this->programs->delete( $id );

		// Successful program record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> program was successfully removed.' , $program->name );

		// Send the user back to the page they were at and display a message
		// that communicate a new program record was deleted.
		// 
		return Redirect::back()->withProgramDeleted( $message );
	}

}