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

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
});


Route::prefix('quiz')->group(function () {
    Route::get('/create/{templateId}', 'UserQuizController@create');
    Route::get('/{quizId}/result', 'UserQuizController@showResult');
    Route::get('/{quizId}/complete', 'UserQuizController@completeQuiz')->middleware(CheckQuizOwner::class);
    Route::get('/{quizId}/{questionNumber}', 'UserQuizController@question')->middleware(CheckQuizOwner::class);
    Route::post('/{quizId}/{questionNumber}', 'UserQuizController@storeAnswer')->middleware(CheckQuizOwner::class);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.',  'middleware' => ['auth', 'roles'], 'roles' => 'administrator'], function () {
    Route::resource('quiz', 'AdminQuizController');
    Route::resource('subject', 'AdminSubjectController');
    Route::resource('quiz-template', 'AdminQuizTemplateController');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);