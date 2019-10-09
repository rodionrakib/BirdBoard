<?php

// \App\Project::created(function($project){
// 	\App\Activity::create([
// 		'project_id' => $project->id,
// 		'description' => 'created'
// 	]);
// });


// \App\Project::updated(function($project){
// 	\App\Activity::create([
// 		'project_id' => $project->id,
// 		'description' => 'updated'
// 	]);
// });


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
    return redirect('/login');
});


Route::patch('/projects/{project}/tasks/{task}','ProjectTaskController@update')->name('task-update')->middleware('auth');
Route::get('/projects/create','ProjectController@create')->name('project-create')->middleware('auth');
Route::post('/projects/{project}/tasks','ProjectTaskController@store')->name('task-store')->middleware('auth');
Route::post('/projects','ProjectController@save')->name('project-save')->middleware('auth');
Route::get('/projects/{project}','ProjectController@show')->middleware('auth');
Route::get('/projects/{project}/edit','ProjectController@edit')->middleware('auth');
Route::patch('/projects/{project}','ProjectController@update');
Route::delete('/projects/{project}','ProjectController@destroy');
Route::post('/projects/{project}/invitation','InvitationController@store')->name('invitation');

Route::get('/projects','ProjectController@index')->middleware('auth');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

