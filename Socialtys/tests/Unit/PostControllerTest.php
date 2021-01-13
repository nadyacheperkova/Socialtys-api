<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Post;
use App\Models\PostLikes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\PostController;
use App\Database\Factories\PostFactory;
use App\Database\Factories\UserFactory;



class PostControllerTest extends TestCase
{
    use WithFaker;
    
    public function testPostIndex()
    {
        
        $post = Post::factory()->make();
        $post2 = Post::factory()->make();
        $post3 = Post::factory()->make();
        $postTestId = $post->id;

        $postList = collect($post, $post2, $post3);

        $postLikesTest = $postList->search($postTestId);
        
        $this->assertNotEmpty($postLikesTest);
    }

    public function testPostLike()
    {
        
        $post = PostLikes::create([
            'user_id' => $this->faker->numberBetween(1,2),
            'post_id' => $this->faker->numberBetween(1,2)
        ]);

        $this->assertNotEmpty($post);
    }

    public function testPostStore()
    {
        
        $post = Post::factory()->make();

        $this->assertNotEmpty($post);
    }

    public function testPostUpdate()
    {
        $post = Post::factory()->make();
        $post->update([
            'text' => 'required',
        ]);

        $this->assertNotEmpty($post);
    }

    public function testPostDestroy()
    {
        $post = Post::factory()->make();
        $post= $post->delete();

        $this->assertIsNotObject($post);
        
    }
   








    
}
