<?php

namespace App\Http\Controllers;

use App\Notifications\AcceptFriend;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    public function findFriends()
    {
        $uid = Auth::user()->id;
        $all_users = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', '!=', $uid)->get();
        return view('profile.findFriends', compact('all_users'));
    }

    public static function check(object $a)
    {
        $check = DB::table('friends')
            ->where('user_requested', '=', $a->id)
            ->where('requester', '=', Auth::user()->id)
            ->first();;
        return $check;
    }

    public function addFriend($id)
    {
        Auth::user()->addFriend($id);
        return back();
    }

    public function requests()
    {
        $uid = Auth::user()->id;
        $friend_request = DB::table('friends')
            ->rightJoin('users', 'users.id', '=', 'friends.requester')
            ->where('status', '=', 0)
            ->where('friends.user_requested', '=', $uid)->get();
        return view('profile.requests', compact('friend_request'));
    }

    public static function requestCount()
    {
        return DB::table('friends')->where('status', 0)->where('user_requested', Auth::user()->id)->count();
    }

    public function accept($id, $name)
    {
        $uid = Auth::user()->id;
        $check_request = DB::table('friends')
            ->where('requester', '=', $id)
            ->where('user_requested', '=', $uid)
            ->first();

        if ($check_request) {
            $updateFriend = DB::table('friends')
                ->where('user_requested', $uid)
                ->where('requester', $id)
                ->update(['status' => 1]);
            $user = User::where('id', $id)->first();
            $notification = new AcceptFriend(Auth::user(), $id);
            $user->notify($notification);
            if ($updateFriend) {
                return back()->with('msg', 'you are now friend with ' . $name);
            } else {
                return back()->with('msg', 'you are now friend with this user');
            }
        }
    }

    public function friends()
    {
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

//        dd($friend);
        return view('profile.friends', compact('friend'));
    }

    public function requestRemove($id)
    {
        $uid = Auth::user()->id;
        $removeRequest = DB::table('friends')
            ->where('user_requested', $uid)
            ->where('requester', $id)
            ->delete();
        if ($removeRequest) {
            return back()->with('msg', 'Request has been deleted');
        } else {
            echo 'fail';
        }
    }

    public function removeFriend($user_requested, $requester)
    {
        $uid = Auth::user()->id;
        $removeFriend = DB::table('friends')
            ->where(function ($q) use ($uid, $user_requested, $requester) {
                $q->where(function ($querry) use ($uid, $user_requested) {
                    $querry->where('user_requested', $user_requested)
                        ->where('requester', $uid);
                })->orWhere(function ($querry) use ($uid, $requester) {
                    $querry->where('user_requested', $uid)
                        ->where('requester', $requester);
                });
            })->update(['status' => 0]);
        if ($removeFriend) {
            return back()->with('msg', 'Friend relationship has been deleted');
        } else {
            echo 'fail';
        }
    }

    public static function addFriendNotifications($id)
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        $data = json_decode(DB::table('notifications')->where('id', $id)->value('data'))->creater_id;
//        return view('profile.findFriends', compact('data'));

    }

    public static function notificationCount()
    {
        $uid = Auth::user()->id;
        $data = json_decode(DB::table('notifications')->pluck('data'))->creater_id;
        dd($data);
//        return DB::table('friends')->where('status', 0)->where('user_requested', Auth::user()->id)->count();
    }
}
