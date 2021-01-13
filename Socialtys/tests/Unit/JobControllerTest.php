<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\JobController;
use App\Database\Factories\JobFactory;
use App\Database\Factories\UserFactory;



class JobControllerTest extends TestCase
{
    use WithFaker;
    
    public function testJobIndex()
    {
        $job = Job::factory()->make();
        $job2 = Job::factory()->make();
        $job3 = Job::factory()->make();
       
        
        $JobList = collect($job, $job2, $job3);

        $this->assertNotEmpty($JobList);
    }

    public function testJobStore()
    {
        $job = Job::factory()->make();
        
        $this->assertNotEmpty($job->title);
    }

    public function testJobShow()
    {
        $job = Job::factory()->make();

        $job->load('user');
        $this->assertNotEmpty($job->title);
    }

    public function testJobUpdate()
    {
        $job = Job::factory()->make();
        $job->update([
            'title' => 'required',
            'company' => 'required',
            'description' => 'required',
            'url' => 'max:255',
            'type' => 'required',
            'user_id' => 'required|exitst:users,id'
        ]);

        $this->assertNotEmpty($job->title);
    }

    public function testJobDestroy()
    {
        $job = Job::factory()->make();
        $job= $job->delete();

        $this->assertIsNotObject($job);
        
    }








    
}
