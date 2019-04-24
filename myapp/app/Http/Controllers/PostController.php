<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getDashboard()
    {
        // Lấy ra tất cả các post được sắp xếp theo thời gian khởi tạo và giảm dần
//        $posts = Post::with('user', 'likes', 'comments')->orderBy('created_at', 'desc')->get();
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
        return view('dashboard', compact('friend'));
    }

    public function addPost(Request $request)
    {
        // set validation rules
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);

        // Tạo đối tượng post mới rồi gán body bằng data của request
        // Bug: id tiếp tục tăng trong khi table trống
        $post = new Post();
        $post->body = $request['body'];
        $message = 'There was an error';
        // Kiểm tra xem post đã được lưu vào database hay chưa
        if ($request->user()->posts()->save($post)) {
            return Post::with('user', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    public function createPostWithImage(Request $request)
    {
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
    public function deletePost($post_id)
    {
        $uid = Auth::user()->id;
        $post = DB::table('posts')
            ->where('id', $post_id)
            ->where('user_id', $uid)
            ->delete();
        if ($post) {
            return Post::with('user', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
        return redirect()->route('dashboard');
    }

    public function deleteLike($post_id)
    {
        $uid = Auth::user()->id;
        $like = DB::table('likes')->where('post_id', $post_id)->where('user_id', $uid)->delete();
        if ($like) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');
    }
    public function likePost($id)
    {
        $likePost = DB::table('likes')->insert([
            'post_id' => $id,
            'user_id' => Auth::user()->id,
        ]);
        if ($likePost) {
            return Post::with('user', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }

    }

    public function addComment(Request $request)
    {
        $comment = $request->comment;
        $id = $request->id;
        $createComment = DB::table('comments')
            ->insert(['comment' => $comment, 'user_id' => Auth::user()->id, 'post_id' => $id,
                'created_at' => Carbon::now()->toDateTimeString()]);
        if ($createComment) {
            return Post::with('user', 'likes', 'comments')->orderBy('created_at', 'DESC')->get();
        }
    }
}
