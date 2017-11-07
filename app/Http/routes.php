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
Route::resource('register','Auth\RegisterController'); //'RegistrationController@create');
Route::resource('verifyEmailUser', 'Auth\RegisterController@verifyEmail');
Route::resource('forgotPassword', 'Auth\ForgotPasswordController');

/* Assignment*/
Route::resource('create', 'AssignmentController@create');
Route::resource('lists', 'AssignmentController@listAssignment');
Route::resource('api/delete', 'AssignmentController@deleteAssignment');
Route::resource('api/listByMonth', 'AssignmentController@listAssignmentByMonth');


/* Course Related APIs*/

Route::resource('createCourse', 'CourseController@create');
Route::resource('createStudentCourse', 'CourseController@createStudentCourse');
Route::resource('update', 'CourseController@update');
Route::resource('updateStudentCourse', 'CourseController@updateStudentCourse');
Route::resource('deleteStudentCourse', 'CourseController@deleteStudentCourse');
Route::resource('lists', 'CourseController@listStudentCourse');


/* User related APIs*/
Route::resource('validateUser', 'UserController@validateUser');
Route::resource('listUsers', 'UserController@getUsers');

/* Push Notification APIs*/
Route::resource('setPushPermission', 'PushNotificationController@activatePush');

/*Thread related APIs*/
Route::resource('getThreadMessage', 'ThreadController@getThreadMessage');
Route::resource('listUserThreads', 'ThreadController@getUserThreads');



Route::get('names', function()
{
    return array(
      1 => "John",
      2 => "Mary",
      3 => "Steven"
    );
});

