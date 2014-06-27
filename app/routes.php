<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Check for authentication for all routes inside this group.
// 
Route::group(['before' => 'auth'], function()
{
    // Homepage
    // 
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    // Departments
    // 
    Route::resource('departments', 'DepartmentController');

    // Department Machines (nested resource)
    // 
    Route::resource('departments.machines', 'DepartmentMachineController');

    // Department Soft-Delete
    // 
    Route::get('departments/{id}/delete', ['as' => 'departments.delete', 'uses' => 'DepartmentController@destroy']);

    // Machines (Computers/Workstations)
    // 
    Route::resource('machines', 'MachineController');

    // Machines Soft-Delete
    // 
    Route::get('machines/{id}/delete', ['as' => 'machines.delete', 'uses' => 'MachineController@destroy']);

    // Machine Program (nested resource)
    // 
    Route::resource('machines.programs', 'MachineProgramController');

    // Machines Soft-Delete
    // 
    Route::get('machines/{id}/programs/{programId}/detach', ['as' => 'machines.programs.detach', 'uses' => 'MachineProgramController@destroy']);

    // Software Programs
    // 
    Route::resource('programs', 'ProgramController');

    // Program Machines (nested resource)
    // 
    Route::resource('programs.machines', 'ProgramMachineController');

    // Programs Soft-Delete
    // 
    Route::get('programs/{id}/delete', ['as' => 'programs.delete', 'uses' => 'ProgramController@destroy']);

    // Software Publishers
    // 
    Route::resource('publishers', 'PublisherController');

    // Publishers Soft-Delete
    // 
    Route::get('publishers/{id}/delete', ['as' => 'publishers.delete', 'uses' => 'PublisherController@destroy']);

});

// Login
// 
Route::resource('login', 'LoginController', ['only' => ['index', 'store']]);

// Logout
// 
Route::get('logout', ['as' => 'logout', function()
{
    // Log the user out of their session.
    // 
    Auth::logout();

    // Successful logout message
    // 
    $message = 'You have successfully logged out.';

    // Send the user back to the login page and display a message
    // that communicate that they were successfully logged out.
    // 
    return Redirect::route('login.index')->withLogoutSuccessful( $message );
}]);

Route::resource('imports', 'ImportController', ['only' => ['index']]);