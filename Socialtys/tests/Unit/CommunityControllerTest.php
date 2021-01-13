<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\CommunityController;
use App\Database\Factories\CommunityFactory;
use App\Database\Factories\UserFactory;



class CommunityControllerTest extends TestCase
{
    use WithFaker;
    

    public function testCommunityIndex()
    {
        $community = Community::factory()->make();
        
        $communities = Community::all();
        $communities->join('user');

        $this->assertNotEmpty($communities);
    }

    

    public function testCommunityStore()
    {
        $community = Community::factory()->make();

        $this->assertNotEmpty($community->name);
    }

    public function testCommunityShow()
    {
        $community = Community::factory()->make();
        $community->load('users', 'posts', 'posts.user', 'posts.comments');
        $this->assertNotEmpty($community);
    }

    public function testCommunityUpdate()
    {
        $community = Community::factory()->make();
        $community->update([
            'name' => '',
            'description' => '',
            'icon' => ''
        ]);

        $this->assertNotEmpty($community);
    }

    public function testCommunityDestroy()
    {
        $community = Community::factory()->make();
        $community= $community->delete();

        $this->assertIsNotObject($community);
        
    }

    public function testCommunitySearch()
    {
        $community = Community::factory()->make();
        $community2 = Community::factory()->make();
        $community3 = Community::factory()->make();
        $commname = $community->name;

        $commList = collect($community, $community2, $community3);
        
        $communities = $commList->search($commname);
        
        $this->assertNotEmpty($communities);
    }

    public function testCommunityJoin()
    {
        $community = Community::factory()->make();
        $user = User::find(1);

        $community->users()->save($user);
        $community->load('users');
        $this->assertNotEmpty($community);
    }
}
   








