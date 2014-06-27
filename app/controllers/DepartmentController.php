<?php

use Acme\Storage\Interfaces\DepartmentRepositoryInterface;
use Acme\Validation\DepartmentValidator;

class DepartmentController extends \BaseController {

	/** 
	 * The department repository implementation.
	 * 
	 * @var Acme\Storage\Repositories\DepartmentRepository
	 */
	protected $departments;

	/** 
	 * The machine validator.
	 * 
	 * @var Acme\Validation\DepartmentValidator
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
		DepartmentValidator $validator 
	){
		$this->departments = $departments;
		$this->validator   = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Fetch all departments from the database.
		// 
		$departments = $this->departments->allPaginated( ['machines'] );

		// Show the page.
		// 
		return View::make('departments.index', compact('departments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Create new department instance.
		// 
		$department = $this->departments->instance();

		// Show the page.
		// 
		return View::make('departments.create', compact('department'));
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

		// Create a new department record.
		// 
		$department = $this->departments->create( $input );

		// Successful department record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> department was successfully added.' , $department->name );

		// Send the user back to the department list page and display a message
		// that communicate a new department record was created.
		// 
		return Redirect::route('departments.index')->withDepartmentAdded( $message );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Fetch the department record from the database.
		// 
		$department = $this->departments->findById( $id );

		// Fetch all computers assigned to the departments.
		// 
		$machines = $department->machines()->paginate();

		// Show the page.
		// 
		return View::make('departments.show', compact('department', 'machines'));
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
		// Fetch the department record from the database.
		// 
		$department = $this->departments->findById( $id );

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

		// Update the department record.
		// 
		$department = $this->departments->update( $id, $input );

		// Successful department record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> department was successfully added.' , $department->name );

		// Send the user back to the department list page and display a message
		// that communicate a new department record was created.
		// 
		return Redirect::route('departments.index')->withDepartmentAdded( $message );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Fetch the department record from the database.
		// 
		$department = $this->departments->findById( $id );

		// Soft-delete the resource from storage.
		// 
		$this->departments->delete( $id );

		// Successful department record message.
		// 
		$message = sprintf( 'The <strong>%s</strong> department was successfully removed.' , $department->name );

		// Send the user back to the page they were at and display a message
		// that communicate a new department record was deleted.
		// 
		return Redirect::back()->withDepartmentDeleted( $message );
	}

}