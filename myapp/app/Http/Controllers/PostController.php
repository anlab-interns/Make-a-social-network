<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getDashboard()
    {
        // Lấy ra tất cả các post được sắp xếp theo thời gian khởi tạo và giảm dần
        $posts = Post::with('user', 'likes')->orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('posts'));
    }

    public function addPost(Request $request)
    {
        // set validation rules
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);

        // Tạo đối tượng post mới rồi gán body bằng data của request
        // Bug: id tiếp tục tăng trong khi bảng trống
        $post = new Post();
        $post->body = $request['body'];

//        $post->user_id = Auth::user()->id;
//        $post->save();
        $message = 'There was an error';
        // Kiểm tra xem post đã được lưu vào database hay chưa
        if ($request->user()->posts()->save($post)) {
//            $post_json = DB::table('posts')
//                ->leftJoin('profiles', 'profiles.user_id', '=', 'posts.user_id')
//                ->leftJoin('users', 'posts.user_id','=', 'users.id')
//                ->select('posts.id', 'users.name','posts.user_id', 'posts.created_at', 'body', 'image')
//                ->get();
//            return $post_json;
            return Post::with('user', 'likes')->orderBy('created_at', 'DESC')->get();
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
        $post->save();
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function deletePost($post_id)
    {
        $uid = Auth::user()->id;
        $post = DB::table('posts')
            ->where('id', $post_id)
            ->where('user_id', $uid)
            ->delete();
        if ($post) {
            return back();
        }

        $like = Like::where('post_id', $post_id)->first();
        if ($like) {
            $like->delete();
        }
        return redirect()->route('dashboard')->with(['message' => 'Post successfully deleted!']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function likePost($id)
    {
        $likePost = DB::table('likes')->insert([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
        ]);
        if ($likePost) {
            return Post::with('user', 'likes')->orderBy('created_at', 'DESC')->get();
        }

    }
}
