<?php

namespace App\Traits;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
trait RegistersUser
{
    public function registerUser($data)
    {
        $bool= true;
        $fields = User::create([
            'firstName' => $data->firstName,
            'lastName' => $data->lastName,
            'occupationField' => $data->occupationField,
            'email' => $data->email,
            'type' => $data->type,
            'skills' => $data->skills,
            'interests' => $data->interests,
            'first_login' => $bool,
            'password' => Hash::make($data->password),
        ]);

        //The user  passed on to JWTAuth to generate an access token for the created user
        $token=JWTAuth::fromUser($fields);

        Mail::to($fields->email)->send(new VerifyEmail($fields));



        return $fields;
    }
}

?>
