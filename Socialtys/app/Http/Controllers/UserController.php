<?php

namespace App\Http\Controllers;


use App\Models\Chat;
use App\Models\LoginActivity;
use App\Models\User;
use App\Models\Community;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getCommunities(User $user)
    {
        $community = $user->communities()->get();
        //return json_encode((object)$community,JSON_FORCE_OBJECT);
        return response()->json((object)$community );
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('communities', 'posts');
        return response()->json($user);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'firstName' => '',
            'lastName' => '',
            'occupationField' => '',
            'password' => '',
        ]));

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json($user);
    }






    /**
     * Search for a user
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request)
    {
        $name = $request->name;
        $users = User::where('firstName', 'lastName', 'LIKE', '%'.$name.'%')->get();
        return response()->json($users);
    }

    public function findOrCreate(Request $request)
    {
        $user = User::firstOrCreate($request->all());
        $redis = Redis::connection();
        $redis->publish('user joined',User::get());
        return response()->json($user, 200);

    }

    public function getUsers()
    {
        return response()->json(User::get('firstName'), 200);
    }

    public function saveMessage(Request $request)
    {
        Chat::create($request->all());
        $redis = Redis::connection();
        $redis->publish('Chat sent',json_encode($request->all()));
        return $request->all();
    }

    public function getMessage(Request $request)
    {
        $chats = Chat::whereIn('sender_id',$request->sender_id)
            ->whereIn('receiver_id', $request->receiver_id)
            ->get();
        return response([ 'chats' => $chats], 200);
    }

    public function LoginAttempt()
    {
        if(Auth::user()->first_login ==true){
            User::where('id',Auth::user()->id)->update(['first_login'=> false]);
            return response()->json(200);
        }
    }

    public function getLoginActivity(Request $request)
    {
        $auth_user = JWTAuth::user()->id;
        $login_activity = LoginActivity::select('access_token')
            ->where('user_id',$auth_user)
            ->where('is_expired',false)
            ->get();
        return response()->json([ 'access_token' => $login_activity],200);
    }
}

