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


class CommentControllerTest extends TestCase
{
    use WithFaker;
    

    public function testCommentAdd()
    {
        $comment = Comment::factory()->make();

        $this->assertNotEmpty($comment->text);
    }

    public function testCommentUpdate()
    {
        $comment = Comment::factory()->make();

        $comment->update([
            'text' => 'required',
        ]);

        $this->assertNotEmpty($comment->text);
    }

    public function testCommentDestroy()
    {
        $comment = Comment::factory()->make();
        $comment= $comment->delete();

        $this->assertIsNotObject($comment);
        
    }

   




    
}
