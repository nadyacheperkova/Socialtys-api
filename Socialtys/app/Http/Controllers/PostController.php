<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use App\Models\PostLikes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $postLikes = Post::with('user','likes')->get();
        return response()->json($postLikes);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($request->validate([
            'text' => 'required',
            'user_id' => 'required|exists:users,id',
            'community_id' => 'required|exists:communities,id'
        ]));

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('user', 'comments');
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->validate([
            'text' => 'required',
        ]));

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json($post);
    }
}
