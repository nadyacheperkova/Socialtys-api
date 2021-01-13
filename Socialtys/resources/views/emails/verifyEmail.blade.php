<!DOCTYPE html>
    <html>
    <head>
        <title>Welcome Email</title>
    </head>
    <body>
        <h2>Welcome to the site {{$user['lname']}} {{$user['fname']}}</h2>
        <br/>
        Your registered email-id is {{$user['email']}} , Please click on the link below to verify your email account
        <br/>
        <a href="{{url('api/user/verify/'. $user->email)}}">Verify Email</a>
    </body>
</html>
