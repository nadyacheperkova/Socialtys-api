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
use App\Database\Factories\PostFactory;
use App\Database\Factories\JobFactory;
use App\Database\Factories\CommunityFactory;
use App\Models\Chat;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostLikes;


class HomerControllerTest extends TestCase
{
    use WithFaker;
    
   
    public function testHomeIndex()
    {
        $post = Post::factory()->make();
        $post2 = Post::factory()->make();
        $post3 = Post::factory()->make();
        $postTestId = $post->id;

        $posts = collect($post, $post2, $post3);
        foreach ($posts as $value){
            $postLikes = PostLikes::where('post_id', $postTestId)->count();
        }

        $this->assertNotEmpty($posts);
    }

    public function testlike()
    {
        $post = Post::factory()->make();
        $post2 = Post::factory()->make();
        $post3 = Post::factory()->make();
        $postTestId = $post->id;
        $posts = collect($post, $post2, $post3);

        $existing_like = PostLikes::wherePostId($postTestId)->whereUserId(Auth::id())->first();

        $this->assertEmpty($existing_like);
        
    }





    
}
