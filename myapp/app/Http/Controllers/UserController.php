<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        // Kiểm tra tính chuẩn xác khi gửi form đăng ký theo yêu cầu được định nghĩa ở dưới
    	$this->validate($request, [
    		'email'=>'required|email|unique:users',
    		'first_name'=>'required|max:120',
    		'password'=>'required|min:4'
    	]);

    	// Gán các biến email, first name và password với dữ liệu mà request mang theo
    	$email=$request['email'];
    	$first_name=$request['first_name'];
    	$password=bcrypt($request['password']);

    	// Tạo user mới, gán các thuộc tính bằng giá trị các biến vừa tạo ra ở trên
        $user=new User();
    	$user->email=$email;
    	$user->first_name=$first_name;
    	$user->password=$password;

    	// Lưu user vào database
    	$user->save();

    	// Login user trong database vào app
    	Auth::login($user);

    	// Chuyển hướng sang route dashboard
        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request)
    {
        // Kiểm tra email và password
    	$this->validate($request, [
    		'email'=>'required',
    		'password'=>'required'
    	]);

    	//Nếu email và passowrd có tồn tại trong database thì chuyển hướng sang route dashboard
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->route('dashboard');
        }
        // Sai thì quay lại và in ra message
        return redirect()->back()->with(['message' => 'Sign in failed!']);;
    }

    public function getLogout()
    {
        // Log out user ra khỏi app cũng như xóa hết các thông tin authentication trong use session
    	Auth::logout();
    	return redirect()->route('home');
    }
}
