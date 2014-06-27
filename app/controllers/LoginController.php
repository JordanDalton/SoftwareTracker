<?php

use Acme\Validation\LoginValidator;

class LoginController extends \BaseController {

	/**
	 * The login validator implementation.
	 * 
	 * @var Acme\Validation\LoginValidator
	 */
	protected $validator;

	/** 
	 * Create new LoginController instance.
	 * 
	 * @param LoginValidator $validator 
	 */
	public function __construct( LoginValidator $validator )
	{
		$this->validator = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('login.index');
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

	    // Set the login credentials.
	    // 
	    $credentials = Input::except('_token');

	    // User has been authenticated.
	    //
	    if ( Auth::attempt( $credentials ) )
	    {
	    	// Send the user to the homepage.
	    	// 
	        return Redirect::route('home');
	    }

		//-------------------------------
		// User failed authentication.
		//-------------------------------
		
	    // Prepare custom error message.
	    // 
	    $errors = [
	    	'login_failed' => 'Invalid login credentials.'
	    ];

		// Send the user back to the form and display error message(s)
		// that communicate that they failed to login due to invalid
		// login credentials.
		// 
		return Redirect::back()->withInput()->withErrors( $errors );
	}

}