<?php

use Acme\Storage\Interfaces\PublisherRepositoryInterface;
use Acme\Validation\PublisherValidator;

class PublisherController extends \BaseController {

	/** 
	 * The publisher repository implementation.
	 * 
	 * @var Acme\Storage\Repositories\PublisherRepository
	 */
	protected $publishers;

	/** 
	 * The publisher validator.
	 * 
	 * @var Acme\Validation\DepartmentValidator
	 */
	protected $validator;

	/** 
	 * Create new DepartmentController instance.
	 * 
	 * @param PublisherRepositoryInterface $publishers
	 * @param PublisherValidator           $validator
	 */
	public function __construct( 
		PublisherRepositoryInterface $publishers, 
		PublisherValidator $validator 
	){
		$this->publishers = $publishers;
		$this->validator  = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Fetch all publishers from the database.
		// 
		$publishers = $this->publishers->allPaginated( ['programs'] );

		// Show the page.
		// 
		return View::make('publishers.index', compact('publishers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Create new Publisher instance.
		// 
		$publisher = $this->publishers->instance();

		// Show the page.
		// 
		return View::make('publishers.create', compact('publisher'));
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

		// Create a new publisher record.
		// 
		$publisher = $this->publishers->create( $input );

		// Successful publisher record message.
		// 
		$message = sprintf( '<strong>%s</strong> was successfully added.' , $publisher->name );

		// Send the user back to the publisher list page and display a message
		// that communicate a new publisher record was created.
		// 
		return Redirect::route('publishers.index')->withPublisherAdded( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Fetch the publisher record.
		// 
		$publisher = $this->publishers->findById( $id );

		// Fetch all programs that belong to the publisher.
		// 
		$programs = $publisher->programs()->paginate();

		// Show the page.
		// 
		return View::make('publishers.show', compact('programs', 'publisher'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Fetch the publisher record.
		// 
		$publisher = $this->publishers->findById( $id );

		// Show the page.
		// 
		return View::make('publishers.edit', compact('publisher'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Fetch the publisher record.
		// 
		$publisher = $this->publishers->findById( $id );

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

		// Update the publisher record.
		// 
		$publisher = $this->publishers->update( $id, $input );

		// Successful publisher record message.
		// 
		$message = sprintf( '%s change was successful.' , $publisher->name );

		// Send the user back to the publisher list page and display a message
		// that communicate a new publisher record was updated.
		// 
		return Redirect::route('publishers.index')->withPublisherUpdated( $message );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Fetch the publisher record from the database.
		// 
		$publisher = $this->publishers->findById( $id , ['programs']);

		// Loop through all of the publishers program and detach their installation record
		// from each machine, then delte the program.
		// 
		$publisher->programs->each(function($program){
			$program->machines()->detach();
			$program->delete();
		});

		// Soft-delete the resource from storage.
		// 
		$this->publishers->delete( $id );

		// Successful publisher record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> publisher was successfully removed.' , $publisher->name );

		// Send the user back to the page they were at and display a message
		// that communicate a new publisher record was deleted.
		// 
		return Redirect::back()->withPublisherDeleted( $message );
	}

}