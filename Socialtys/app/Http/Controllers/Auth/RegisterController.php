<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Traits\RegistersUser;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    use RegistersUser;

    public function index()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $data)
    {
        if($this->registerUser($data)){
            return response()
                ->json(['message'=>'Account successfully created. Please check your email for verification'], 200);
        }else{
            return response()
                ->json(['message'=>'Account could not be created. Please try again'], 400);
        }
    }
    
    public function verifyUser($email)
    {
        $token = now();
        $user = User::where('email' , $email)->get();
        //dd($use);
        User::where('email', $email)
            ->update([
                'email_verified_at' => $token
            ]);

        return response()->json('Account successfully verified',200);

        return redirect()->away('http://localhost:8080/signIn');
        //return response()->json('Account successfully verified',200);
        //return response()->json('Could not verify account. Please try again later!.', 400);
    }
}
