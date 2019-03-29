<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
	 public function getDashboard()
    {
        // Lấy ra tất cả các post được sắp xếp theo thời gian khởi tạo và giảm dần
    	$posts= Post::orderBy('created_at','desc')->get();
    	return view('dashboard', ['posts' => $posts]);
    }

    public function postCreatePost(Request $request)
    {
//        dd();
        // set validation rules
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);

        // Tạo đối tượng post mới rồi gán body bằng data của request
    	$post=new Post();
    	$post->body=$request['body'];
    	$message = 'There was an error';

        // Kiểm tra xem post đã được lưu vào database hay chưa
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function createPostWithImage(Request $request)
    {
//        dd($request->user()->posts());
        // set validation rules
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);
        $file = $request->file('pic_post');
        $file_name = $file->getClientOriginalName();
        $body = $request['body'];
        $path = 'public/images';
        $file->move($path, $file_name);
        // Tạo đối tượng post mới rồi gán giá trị các trường bằng data của request

        $post = new Post();
        $post->body = $body;
        $post->image = $file_name;
        $message = 'There was an error';
//        $post->save();
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function getDeletePost($post_id)
    {
        $post=Post::where('id',$post_id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Post successfully deleted!']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body'=>'required'
        ]);
        $post= Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body=$request['body'];
        $post->update();
        return response()->json(['new_body'=>$post->body],200);
    }
}
