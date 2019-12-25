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

Route::get('/quizPage/{token}', 'QuizPageController@show')->name('quizPage');
Route::post('/replyQuestion', 'QuizPageController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'EditController@show')->name('edit');
Route::get('/query/{id}', 'EditController@findById');
Route::get('/findProspects/{id}', 'ProspectController@index');
Route::get('/fetchAnswer/{id}/{prospect}', 'QuizPageController@findById');

Route::resource('/quizzes', 'QuizzesController');
Route::post('/creatQuestion', 'EditController@store');
Route::post('/editQuestion', 'EditController@creatAndUpdate');
Route::post('/addProspect', 'ProspectController@store');
Route::post('/sendForm/{id}', 'ProspectController@update');


Route::delete('/delQuestion/{id}', 'EditController@destroy');
Route::delete('/delProspect/{id}', 'ProspectController@destroy');

Route::get('/send-mail/{id}', 'EmailController@store');

