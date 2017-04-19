<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('Admin');
});


Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::get('/subjectview/{course_id}', 'SubjectViewController@index', array('course_id'));
Route::resource('subjectview','SubjectViewController',  ['except' => ['index']]);

Route::get('/questionbuilder/{exam_id}', 'QuestionBuilderController@index', array('exam_id'));
Route::resource('questionbuilder','QuestionBuilderController',  ['except' => ['index']]);

Route::get('/viewresults/{exam_id}', 'ViewResultsController@index', array('exam_id'));
Route::resource('viewresults','ViewResultsController',  ['except' => ['index']]);

//Route::get('/quiz/{exam_id}', 'QuizController@index', array('exam_id'));
//Route::resource('quiz','QuizController',  ['except' => ['index']]);

//Route::post('quiz/result',['middleware' => 'auth','uses' => 'QuizController@result']);

//Route::get('quizquestions/{exam_id}',['middleware' => 'auth', 'uses' => 'QuizController@getQuiz']);
Route::get('/quiz', 'QuizController@index');
Route::resource('quiz','QuizController');
Route::get('quizquestions/{exam_id}', 'QuizController@getQuiz');
Route::post('submittedexam/{id}','QuizController@submittedExam');


Route::post('getgrade','SubjectViewController@storeGrade');

Route::resource('announcement','AnnouncementController');
Route::post('changeannouncestatus/{id}','AnnouncementController@updateAnnounceStatus');
Route::post('deactivateannounce/{id}','AnnouncementController@deactivateAnnounce');

Route::resource('module','ModuleController');
Route::get('getmodule/{filename}','ModuleController@getModule');
Route::post('deactivatemodule/{id}','ModuleController@deactivateModule');

Route::resource('exam','ExamController');
Route::post('changeexamstatus/{id}','ExamController@updateExamStatus');
Route::post('deactivateexam/{id}','ExamController@deactivateExam');

//HOMEWORK controller
Route::resource('homework','HomeworkController');
//SEATWORK controller
Route::resource('seatwork','SeatworkController');

Route::get('/student', 'StudentDashboardController@index');
Route::get('/professor', 'ProfessorDashboardController@index');
Route::resource('studentdashboard','StudentDashboardController');
Route::resource('professordashboard','ProfessorDashboardController');

Route::get('/dashboard', 'DashboardController@index');
Route::resource('dashboard','DashboardController');


Route::get('/adminusermanagement', 'AdminUserManagementController@index');
Route::post('deactivateuser/{id}','AdminUserManagementController@deactivateUser');

Route::get('/admincoursemanagement', 'AdminCourseManagementController@index');
Route::get('/adminsubjectmanagement', 'AdminSubjectManagementController@index');
Route::get('/adminsectionmanagement', 'AdminSectionManagementController@index');
Route::get('/adminstudentmanagement', 'AdminStudentManagementController@index');


Route::resource('adminusermanagement','AdminUserManagementController');
Route::resource('admincoursemanagement','AdminCourseManagementController');
Route::resource('adminsubjectmanagement','AdminSubjectManagementController');
Route::resource('adminsectionmanagement','AdminSectionManagementController');
Route::resource('adminstudentmanagement','AdminStudentManagementController');


Route::get('upload' ,'UserImportController@showForm');
Route::post('upload' ,'UserImportController@store');
Route::get('download', 'UserExportController@download');

Route::get('uploads' ,'SubjectImportController@showForm');
Route::post('uploads' ,'SubjectImportController@store');
Route::get('downloads', 'SubjectExportController@download');

Route::get('uploadse' ,'SectionImportController@showForm');
Route::post('uploadse' ,'SectionImportController@store');
Route::get('downloadse', 'SectionExportController@download');

Route::get('uploadst' ,'StudentImportController@showForm');
Route::post('uploadst' ,'StudentImportController@store');
Route::get('downloadst', 'StudentExportController@download');

Route::get('uploadc' ,'CourseImportController@showForm');
Route::post('uploadc' ,'CourseImportController@store');
Route::get('downloadc', 'CourseExportController@download');


//MAATWEBSITE
Route::get('importExport', 'MaatwebsiteController@importExport');
Route::get('downloadExcel/{type}', 'MaatwebsiteController@downloadExcel');
Route::post('importExcel', 'MaatwebsiteController@importExcel');
//Route::get('/examform/{exam_id}', 'ExamFormController@index', array('exam_id'));
//Route::resource('examform','ExamFormController' , ['except'=>['index']]);
//Route::post('addchoice',['as' => 'addchoice', 'uses' => 'QuestionBuilderController@storeChoice']);
//Route::post('addexam',['as' => 'addexam', 'uses' => 'SubjectViewController@storeExam']);
//Route::post('changeexamstatus/{id}','SubjectViewController@updateExamStatus');
//Route::post('addentry',['as' => 'addentry', 'uses' => 'SubjectViewController@add']);
//Route::get('getentry/{filename}',['as' => 'getentry', 'uses' => 'SubjectViewController@get']);
//Route::post('storeexam','SubjectViewController@storeExam');
//Route::post('editexam/{id}','SubjectViewController@editExam');
//Route::post('storeannounce', 'SubjectViewController@storeAnnounce');
//Route::post('editannounce/{id}','SubjectViewController@editAnnounce');
//Route::post('storemodule','SubjectViewController@storeModule');
//Route::get('getmodule/{filename}','SubjectViewController@getModule');
//Route::post('deactivatemodule/{id}','SubjectViewController@deactivateModule');
