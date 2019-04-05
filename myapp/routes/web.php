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
        'uses' => 'PostController@addPost',
        'as' => 'addPost'
    ]);

    Route::post('/createPostWithImage', 'PostController@createPostWithImage')->name('createPostImage');

    Route::get('/delete-post/{post_id}', [
        'uses' => 'PostController@deletePost',
        'as' => 'deletePost'
    ]);

    Route::get('/addFriend/{id}', 'FriendController@addFriend')->name('addFriend');

    Route::get('/likePost/{id}', 'PostController@likePost')->name('likePost');

    Route::get('/profile/{name}', 'ProfileController@index')->name('profile');

    Route::post('/updatePhoto', 'ProfileController@updatePhoto')->name('updatePhoto');

    Route::get('/editProfile', 'ProfileController@editProfile')->name('editProfile');

    Route::post('updateProfile', 'ProfileController@updateProfile')->name('updateProfile');

    Route::get('/findFriends', 'FriendController@findFriends')->name('findFriend');

    Route::get('/requests', 'FriendController@requests')->name('requests');

    Route::get('/accept/{id}/{name}', 'FriendController@accept')->name('acceptFriend');

    Route::get('/friends', 'FriendController@friends')->name('friends');

    Route::get('/requestRemove/{id}', 'FriendController@requestRemove')->name('requestRemove');

    Route::get('/removeFriend/{id}', 'FriendController@removeFriend')->name('removeFriend');

    Route::get('/addFriendNotifications/{id}', 'FriendController@addFriendNotifications')->name('addFriendNotifications');
});


Route::post('/edit', [
    'uses' => 'PostController@postEditPost',
    'as' => 'edit'
]);

Route::get('/changePhoto', function () {
    return view('profile.photo')->with('data', Auth::user()->profile);
})->name('changePhoto');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard/count', function () {
//    $data = json_decode(DB::table('notifications')->pluck('data'));
//    dd($data);
    return App\Post::with('user', 'likes')->orderBy('created_at', 'DESC')->get();
});
Route::get('/try', function () {
    return App\Post::with('user', 'likes')->orderBy('created_at', 'DESC')->get();
});