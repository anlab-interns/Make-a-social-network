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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/getAllUsers', function () {
        return App\User::all();
    })->name('getAllUsers');

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

    Route::get('/deleteLike/{id}', 'PostController@deleteLike')->name('deleteLike');

    Route::get('/showComments/{id}', 'PostController@showComments')->name('showComments');

    Route::post('/addComment', 'PostController@addComment')->name('addComment');

    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);

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
Route::get('/chat', 'ChatController@index')->middleware('auth')->name('chat');


Route::get('/getUserLogin', 'ChatController@getUserLogin')->middleware('auth');

Route::get('/messages', 'ChatController@getMessage')->middleware('auth');

Route::post('/messages', 'ChatController@postMessage')->middleware('auth');

Route::get('/privateMessages/{id}', 'ChatController@getPrivateMessage')->middleware('auth');

Route::post('/privateMessages', 'ChatController@postPrivateMessage')->middleware('auth');


Route::get('/changePhoto', function () {
    return view('profile.photo')->with('data', Auth::user()->profile);
})->name('changePhoto');


Route::get('/getFriendList', function () {
    $uid = Auth::user()->id;
    $friend1 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.user_requested')
        ->where('status', 1)
        ->where('requester', $uid)
        ->get();
    $friend2 = DB::table('friends')->leftJoin('users', 'users.id', 'friends.requester')
        ->where('status', 1)
        ->where('user_requested', $uid)
        ->get();;

    $friend = array_merge($friend1->toArray(), $friend2->toArray());
    return $friend;
})->name('getFriendId');

Route::get('/dashboard/count', function () {
    return App\Post::with('user', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
});

//Route::get('test-broadcast', function () {
//    broadcast(new App\Events\PrivateEvent(Auth::user()));
//});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();