<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use App\Models\CommunityUser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communities = Community::all();
        $communities->join('user');
        return response()->json($communities);
    }

    public function test()
    {
        return Post::with('likes')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $community = Community::create($request->validate([
            'name' => 'required',
            'description' => 'max:255',
            'icon' => ''
        ]));

        /*$addUserToCommunity = CommunityUser::create([
            'user_id' => Auth::id(),
            'community_id' => $community->id
        ]);*/

        return response()->json($community, $addUserToCommunity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community)
    {
        $community->load('users', 'posts', 'posts.user', 'posts.comments');
        return response()->json($community);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community)
    {
        $community->update($request->validate([
            'name' => '',
            'description' => '',
            'icon' => ''
        ]));

        return response()->json($community);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        $community->delete();

        return response()->json($community);
    }

    /**
     * Search for a community
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request)
    {
        $name = $request->name;
        $communities = Community::where('name', 'LIKE', '%'.$name.'%')->get();
        return response()->json($communities);
    }

    /**
     * Join a community
     *
     * @param  \Illuminate\Http\Community $community
     */
    public function join(Community $community, User $user)
    {
        $community->users()->save($user);
        $community->load('users');
        return response()->json($community);
    }
}
