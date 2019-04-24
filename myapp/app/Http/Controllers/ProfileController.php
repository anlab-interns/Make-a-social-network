<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //
    public function index($name)
    {
        $userData = DB::table('users')
            ->leftJoin('profiles', 'profiles.user_id', 'users.id')
            ->where('name', $name)
            ->get();

        return view('profile.profile', compact('userData'));
    }

    public function updatePhoto(Request $request)
    {
//        dd($request->all());
        $file = $request->file('pic');
        $file_name = $file->getClientOriginalName();
        $path = 'public/images';
        $file->move($path, $file_name);
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        DB::table('users')
            ->where('id', $user_id)
            ->update(['picture_path' => $file_name]);
        return redirect()->route('profile', ['name' => $name]);
    }

    public function editProfile()
    {
        return view('profile.editProfile')->with('data', Auth::user()->profile);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        return redirect()->route('profile', ['name' => $name]);
    }


}
