<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->except(['_token']);


        $verify= User::where(['email' => $request->email,'email_verified_at' => null])
            ->get();

        //dd($verify);

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
            else {
                if ($verify->isEmpty() == true) {
                    //Prevent multiple row on same user in login activity records
                    $login_activity_check = LoginActivity::where('user_id', JWTAuth::user()->id)
                        ->where('is_expired','true')
                        ->pluck('is_expired')
                        ->all();

                    //dd($login_activity_check);
                    // Add new login activity record

                    if($login_activity_check == null || $login_activity_check == 'true'){
                        $login_activity = LoginActivity::create([
                            'user_id' => JWTAuth::user()->id,
                            'access_token' => $token,
                            'is_expired' => false,
                        ]);
                    }


                    $attempts = User::select('first_login')
                        ->where('id', $user = JWTAuth::user()->id)
                        ->get();
                    return response()->json([
                        'access_token' => $token,
                        'user' => JWTAuth::user(),
                        'attempts' => $attempts,
                    ],
                        200)->header('Authorization', $token);
                    //return view('home');
                } else {
                    return response()->json('Account not verified or does not exist', 404);
                }
            }
        }catch (JWTException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function authenticateAndroidApp(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->except(['_token']);


        $verify= User::where(['email' => $request->email,'email_verified_at' => null])
            ->get();

        //dd($verify);

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
            else {
                if ($verify->isEmpty() == true) {
                    //Prevent multiple row on same user in login activity records
                    $login_activity_check = LoginActivity::where('user_id', JWTAuth::user()->id)
                        ->where('is_expired','true')
                        ->pluck('is_expired')
                        ->all();

                    //dd($login_activity_check);
                    // Add new login activity record

                    if($login_activity_check == null || $login_activity_check == 'true'){
                        $login_activity = LoginActivity::create([
                            'user_id' => JWTAuth::user()->id,
                            'access_token' => $token,
                            'is_expired' => false,
                        ]);
                    }


                    $attempts = User::select('first_login')
                        ->where('id', $user = JWTAuth::user()->id)
                        ->get();
                    return response()->json(JWTAuth::user(), 200)->header('Authorization', $token);
                    //return view('home');
                } else {
                    return response()->json('Account not verified or does not exist', 404);
                }
            }
        }catch (JWTException $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        LoginActivity::where('user_id', $request)
            ->update([
                'is_expired' => 'true'
            ]);
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }

    public function getAuthenticatedUser(Request $request)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (TokenExpiredException $e) {

            return response()->json(['TokenExpiredException error:' => $e]);

        } catch (TokenInvalidException $e) {

            return response()->json(['TokenInvalidException error :' => $e]);

        } catch (JWTException $e) {

            return response()->json(['JWTException error : , '=> $e]);

        }

        return response()->json($user);
    }
}

