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

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/* Registration API */
Route::resource('api/createUser','Auth\RegisterController@create'); //'RegistrationController@create');
Route::resource('api/verifyEmailUser', 'RegistrationController@verifyEmail');
Route::resource('api/userForgotPassword', 'RegistrationController@userForgotPassword');

/* Assignment*/
Route::resource('api/create', 'AssignmentController@create');
Route::resource('api/lists', 'AssignmentController@listAssignment');
Route::resource('api/delete', 'AssignmentController@deleteAssignment');
Route::resource('api/listByMonth', 'AssignmentController@listAssignmentByMonth');


/* Course Related APIs*/

Route::resource('api/createCourse', 'CourseController@create');
Route::resource('api/createStudentCourse', 'CourseController@createStudentCourse');
Route::resource('api/update', 'CourseController@update');
Route::resource('api/updateStudentCourse', 'CourseController@updateStudentCourse');
Route::resource('api/deleteStudentCourse', 'CourseController@deleteStudentCourse');
Route::resource('api/lists', 'CourseController@listStudentCourse');


/* User related APIs*/
Route::resource('api/validateUser', 'UserController@validateUser');
Route::resource('api/listUsers', 'UserController@getUsers');

/* Push Notification APIs*/
Route::resource('api/setPushPermission', 'PushNotificationController@activatePush');

/*Thread related APIs*/
Route::resource('api/getThreadMessage', 'ThreadController@getThreadMessage');
Route::resource('api/listUserThreads', 'ThreadController@getUserThreads');


Route::resource('api/createAudit', 'AuditController@create');
Route::resource('api/listAuditSchedule', 'AuditController@listSchedule');
Route::resource('api/listAuditPending',  'AuditController@listPending');
Route::resource('api/listAuditExecuted', 'AuditController@listExecuted');
Route::resource('api/updateAudit', 'AuditController@update');
Route::resource('api/getAuditById', 'AuditController@view');
Route::resource('api/playAudit', 'AuditController@playAudit');
Route::resource('api/getQuestionBySectionForAudit', 'AuditController@getQuestionBySectionForAudit');
Route::resource('api/answerAudit', 'AuditController@answerAudit');
Route::resource('api/uploadAnswerAudit', 'AuditController@uploadAnswerAudit');
Route::resource('api/removeUploadAnswerAudit', 'AuditController@removeUploadAnswerAudit');
Route::resource('api/uploadSignatureAudit', 'AuditController@uploadSignatureAudit');
Route::resource('api/finalPlayAudit', 'AuditController@finalPlayAudit');
Route::resource('api/validateQRcode', 'AuditController@validateQRcode');
Route::resource('api/uploadAuditQR', 'AuditController@uploadQRAudit');
Route::resource('api/auditExport', 'AuditController@exportAudit');
Route::resource('api/assignCarToUser', 'AuditController@assignCarToUser');
Route::resource('api/deleteQuestionTagEntry', 'AuditController@deleteQuestionTagEntry');
Route::resource('api/checkRecurringAudit', 'AuditController@checkRecurringAudit');
Route::resource('api/printChecklist', 'AuditController@printChecklist');
Route::resource('api/deleteAudit', 'AuditController@deleteAudit');
Route::resource('api/getTags', 'AuditController@getTags');
Route::resource('api/getCountNewAudits', 'AuditController@getCountNewAudits');



Route::resource('api/listSite', 'SiteController@lists');
Route::resource('api/listAuditor', 'CustomerController@listAuditor');
Route::resource('api/login', 'Auth\AuthController@login');
Route::resource('api/setUserTimeZone', 'AuditController@setUserTimeZone');
Route::resource('api/logout', 'Auth\AuthController@logout');
Route::resource('api/isLogin','Auth\AuthController@isLogin');


Route::get('names', function()
{
    return array(
      1 => "John",
      2 => "Mary",
      3 => "Steven"
    );
});

