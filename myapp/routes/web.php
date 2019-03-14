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
})->name('welcome');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [
        'uses' => 'PostController@getDashBoard',
        'as' => 'dashboard',
    ]);

    Route::post('/createpost', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create'
    ]);

    Route::get('/delete-post/{post_id}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete'
    ]);
    Route::get('/profile', 'ProfileController@index')->name('profile');

    Route::get('/findFriends', 'ProfileController@findFriends')->name('findFriend');

    Route::get('/requests', 'ProfileController@requests')->name('requests');

    Route::get('/accept/{id}/{name}', 'ProfileController@accept')->name('acceptFriend');

    Route::get('/friends', 'ProfileController@friends')->name('friends');

    Route::get('/requestRemove/{id}', 'ProfileController@requestRemove')->name('requestRemove');

    Route::get('/removeFriend/{id}', 'ProfileController@removeFriend')->name('removeFriend');
});


Route::post('/edit', [
    'uses' => 'PostController@postEditPost',
    'as' => 'edit'
]);

Route::get('/changePhoto', function () {
    return view('profile.photo')->with('data', Auth::user()->profile);
})->name('changePhoto');

Route::post('/updatePhoto', 'ProfileController@updatePhoto')->name('updatePhoto');

Route::get('/editProfile', 'ProfileController@editProfile')->name('editProfile');

Route::post('updateProfile', 'ProfileController@updateProfile')->name('updateProfile');

Route::get('/test', function () {
    return Auth::user()->test();
});

Route::get('/addFriend/{id}', 'ProfileController@addFriend')->name('addFriend');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
