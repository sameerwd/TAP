<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'WelcomeController@index');

/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/* Registration API */
Route::get('register','Auth\RegisterController@create'); //'RegistrationController@create');
Route::get('verifyEmailUser', 'Auth\LoginController@verifyEmailUser');
Route::get('forgotPassword', 'Auth\ForgotPasswordController@forgotPassword');

/* Assignment*/
Route::get('listAssignments', 'AssignmentController@listAssignment');
Route::get('delete', 'AssignmentController@delete');
Route::get('listByMonth', 'AssignmentController@listAssignmentByMonth');


/* Course Related APIs*/
Route::get('createCourse', 'CourseController@create');
Route::get('createStudentCourse', 'CourseController@createStudentCourse');
Route::get('update', 'CourseController@update');
Route::get('updateStudentCourse', 'CourseController@updateStudentCourse');
Route::get('deleteStudentCourse', 'CourseController@deleteStudentCourse');
Route::get('listStudentCourse', 'CourseController@listStudentCourse');


/* User related APIs*/
Route::get('users', 'UserController@validateUser');

/* Push Notification APIs*/
Route::get('setPushPermission', 'PushNotificationController@activatePush');

/*Thread related APIs*/
Route::get('getThreadMessage', 'ThreadController@getThreadMessage');
Route::get('listUserThreads', 'ThreadController@getUserThreads');



Route::get('names', function()
{
    return array(
      1 => "John",
      2 => "Mary",
      3 => "Steven"
    );
});

