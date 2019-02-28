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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/signup', [
//    'uses' => 'UserController@postSignUp',
//    'as' => 'signup'
//]);
//
//Route::post('/signin', [
//    'uses' => 'UserController@postSignIn',
//    'as' => 'signin'
//]);
//
//Route::get('/logout', [
//	'uses' => 'UserController@getLogout',
//	'as' => 'logout'
//]);
//
//Route::get('/dashboard', [
//    'uses' => 'PostController@getDashBoard',
//    'as' => 'dashboard',
//])->middleware('auth');
//
//Route::post('/createpost', [
//	'uses' => 'PostController@postCreatePost',
//	'as' => 'post.create'
//])->middleware('auth');
//
//Route::post('/edit', [
//	'uses' => 'PostController@postEditPost',
//	'as' => 'edit'
//]);
//
//Route::get('/delete-post/{post_id}',[
//	'uses' => 'PostController@getDeletePost',
//	'as' => 'post.delete'
//])->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
