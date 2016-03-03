<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('app');
});

Route::post('oauth/access_token', function() {
	return Response::json(Authorizer::issueAccessToken());	
});

Route::group(['middleware'=>'oauth'], function() {

	// Rotas relacionadas a Client

	Route::resource('client', 'ClientController', ['except'=>['create', 'edit']]);

	// Rotas relacionadas a ProjectFile

	Route::group(['middleware'=>'check-file-member'], function() {
		Route::delete('project/file/{file}', 'ProjectFileController@destroy');
		Route::put('project/file/{file}', 'ProjectFileController@update');
		Route::get('project/file/{file}/download', 'ProjectFileController@showFile');
	});

	Route::group(['middleware'=>'check-project-member'], function() {
		Route::post('project/file', 'ProjectFileController@store');
		Route::get('project/file/{project}', 'ProjectFileController@index');
		Route::get('project/file/{project}/{file}', 'ProjectFileController@show');
	});

	// Rotas relacionadas a ProjectTask

	Route::group(['middleware'=>'check-project-member'], function() {
		Route::post('project/task', 'ProjectTaskController@store');
		Route::get('project/task/{project}', 'ProjectTaskController@index');
		Route::get('project/task/{project}/{task}', 'ProjectTaskController@show');
	});

	Route::group(['middleware'=>'check-task-member'], function() {
		Route::delete('project/task/{task}', 'ProjectTaskController@destroy');
		Route::put('project/task/{task}', 'ProjectTaskController@update');
	});

	// Rotas relacionadas a ProjectNote

	Route::group(['middleware'=>'check-project-member'], function() {
		Route::post('project/note', 'ProjectNoteController@store');
		Route::get('project/note/{project}', 'ProjectNoteController@index');
		Route::get('project/note/{project}/{note}', 'ProjectNoteController@show');
	});

	Route::group(['middleware'=>'check-note-member'], function() {
		Route::delete('project/note/{note}', 'ProjectNoteController@destroy');
		Route::put('project/note/{note}', 'ProjectNoteController@update');
	});

	// Rotas relacionadas a ProjectMember

	// Atencao: o resource abaixo criaria o padrao project/{project}/member/{member} :
	//Route::resource('project.member', 'ProjectMemberController', ['except'=>['create', 'edit', 'update']]);

	Route::group(['middleware'=>'check-project-member'], function() {
		Route::get('project/{project}/member', 'ProjectMemberController@index');
		Route::get('project/{project}/member/{member}', 'ProjectMemberController@show');
	});

	Route::group(['middleware'=>'check-project-owner'], function() {
		Route::post('project/{project}/member', 'ProjectMemberController@store');
		Route::delete('project/{project}/member/{member}', 'ProjectMemberController@destroy');
	});

	// Rotas relacionadas a Project

	Route::get('project', 'ProjectController@index');
	Route::post('project', 'ProjectController@store');

	Route::group(['middleware'=>'check-project-member'], function() {
		Route::get('project/{project}', 'ProjectController@show');
	});

	Route::group(['middleware'=>'check-project-owner'], function() {
		Route::delete('project/{project}', 'ProjectController@destroy');
		Route::put('project/{project}', 'ProjectController@update');
	});

	Route::get('user/authenticated', 'UserController@authenticated');

	Route::resource('user', 'UserController', ['except'=>['create', 'edit']]);

});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});


/*
|--------------------------------------------------------------------------
| Catching invalid routes
|--------------------------------------------------------------------------
*/
/*
Route::any( '{catchall}', function ( $page ) {
    return [
        'error' => true,
        'message' => 'Rota invalida!',
    ];
});
*/

