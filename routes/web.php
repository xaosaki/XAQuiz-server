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
use \App\Http\Middleware\CheckQuizOwner;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/quizzes-list', 'HomeController@userQuizzes')->name('quizzes-list');




Route::prefix('quiz')->group(function () {
    Route::post('/create', 'UserQuizController@create');
    Route::get('/info/{templateId}', 'UserQuizController@info');
    Route::get('/{quizId}/result', 'UserQuizController@showResult');
    Route::get('/{quizId}/complete', 'UserQuizController@completeQuiz')->middleware(CheckQuizOwner::class);
    Route::get('/{quizId}/{questionNumber}', 'UserQuizController@question')->middleware(CheckQuizOwner::class);
    Route::post('/{quizId}/{questionNumber}', 'UserQuizController@storeAnswer')->middleware(CheckQuizOwner::class);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.',  'middleware' => ['auth', 'roles'], 'roles' => 'administrator'], function () {
    Route::resource('quiz', 'AdminQuizController');
    Route::resource('subject', 'AdminSubjectController');
    Route::resource('quiz-template', 'AdminQuizTemplateController');
    Route::resource('question', 'AdminQuestionController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('users', 'UsersController');
    Route::get('/import-question', 'ImportController@import')->name('import-question');
    Route::post('/import-question', 'ImportController@postImport')->name('import-question-post');
    Route::get('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
});
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'roles'], 'roles' => 'administrator'], function () {
    Route::get('admin', 'AdminController@index');
});


Auth::routes();

