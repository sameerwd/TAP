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
Route::post('register','Auth\RegisterController@create'); //'RegistrationController@create');
Route::post('verifyEmailUser', 'UserController@validateUser');
Route::post('forgotPassword', 'Auth\ForgotPasswordController@forgotPassword');
Route::post('login', 'Auth\LoginController@login');
Route::post('checkEmail','Auth\RegisterController@checkEmail');

/* Assignment*/
Route::post('listAssignments', 'AssignmentController@listAssignment');
Route::post('deleteAssignment', 'AssignmentController@deleteAssignment');
Route::post('listAssignmentByMonth', 'AssignmentController@listAssignmentByMonth');
Route::post('updateAssignment', 'AssignmentController@updateAssignment');
Route::post('getFriends', 'AssignmentController@getFriends');
Route::post('getStudents', 'StudentController@getStudents');
Route::post('createAssignment', 'AssignmentController@create');

/* Course Related APIs*/
Route::post('createCourse', 'CourseController@create');
Route::post('createStudentCourse', 'CourseController@createStudentCourse');
Route::post('updateCourse', 'CourseController@updateCourse');
Route::post('updateStudentCourse', 'CourseController@updateStudentCourse');
Route::post('deleteStudentCourse', 'CourseController@deleteCourse');
Route::post('deleteInstructorCourse', 'CourseController@deleteInstructorCourse');
Route::post('listStudentCourse', 'CourseController@listStudentCourses');
Route::post('listInstructorCourse', 'CourseController@listInstructorCourses');
Route::post('updateInstructorCourse', 'CourseController@updateInstructorCourse');

/* Push Notification APIs*/
//Route::post('setPushPermission', 'PushNotificationController@activatePush');

/*Message related APIs*/
Route::post('getThreads', 'ChatController@getThreads');
Route::post('getThreadMessage', 'ChatController@getThreadMessage');
Route::post('getUserThread', 'ChatController@getUserThreads');
Route::post('listUserThreads', 'ChatController@getUserThreads');
Route::post('saveMessage', 'ChatController@saveMessage');
Route::post('updateNotificationPermission', 'PushNotificationController@activatePush');


/*System Related APIs*/
Route::post('getTAPPosts', 'SettingsController@getTAPPosts');
Route::post('getTAPInstructorPosts', 'SettingsController@getTAPInstructorPosts');


Route::get('names', function()
{
    return array(
      1 => "John",
      2 => "Mary",
      3 => "Steven"
    );
});

