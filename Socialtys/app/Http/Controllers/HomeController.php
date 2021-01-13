<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        return App\Models\Post::with('likes')->get();
    }
    public function index()
    {
        $posts = Post::all();

        foreach ($posts as $value){
            $postLikes = PostLikes::where('post_id', $value->id)->count();
        }
        //dd($postLikes);
        //$postLikes = PostLikes::where('post_id', $posts->id)->count();

        return view('home')
            ->with('posts', $posts)
            ->with('postLikes', $postLikes);
    }

    public function like(Post $post)
    {
        $existing_like = PostLikes::withTrashed()->wherePostId($post->id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            PostLikes::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id
            ]);
        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }
}
