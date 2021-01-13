<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\CommentController;
use App\Database\Factories\CommentFactory;
use App\Database\Factories\UserFactory;
use App\Models\Chat;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;


class UserControllerTest extends TestCase
{
    use WithFaker;
    

    public function testUserIndex()
    {
        $user = User::factory()->make();
        $user2 = User::factory()->make();
        $user3 = User::factory()->make();
        $userTestName = $user->name;

        $userList = collect($user, $user2, $user3);
        
        $this->assertNotEmpty($userList);
    }

    public function testPostUpdate()
    {
        $user = User::factory()->make();
        $user->update([
            'firstName' => '',
            'lastName' => '',
            'occupationField' => '',
            'password' => '',
        ]);

        $this->assertNotEmpty($user);
    }

    public function testUserDestroy()
    {
        $user = User::factory()->make();
        $user= $user->delete();

        $this->assertIsNotObject($user);
        
    }

    public function testfindOrCreate()
    {
        $user = User::factory()->make();
        $redis = Redis::connection();
        $redis->publish('user joined',User::get());
        
        $this->assertNotEmpty($user);

    }

    public function testgetUsers()
    {

        $usertest= User::get('firstName');

        $this->assertNotEmpty($usertest);
    }

    public function testsaveMessage()
    {
        $chat = Chat::factory()->make();

        $redis = Redis::connection();
        $redis->publish('Chat sent', $chat);
        $this->assertNotEmpty($redis);
    }
    


    public function testgetMessage()
    {
        $chats = Chat::whereIn('sender_id',[1])
            ->whereIn('receiver_id', [2])
            ->get();
            $this->assertEmpty($chats);
    }
    


    public function testLoginAttempt()
    {
        $user = User::factory()->make();

        {
            User::where('id',1);
            $this->assertNotEmpty($user);
        }
    }






    
}
