<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectFeatureTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

        /** @test */
        public function oguest_cannot_create_project()
        {
            // $this->withoutExceptionHandling();
            $attributes = Project::factory()->raw();
            $this->post('/projects',$attributes)->assertRedirect('login');
        }

        /** @test */
        public function Gues_cannot_view_project()
        {
          
            $this->get('/projects')->assertRedirect('login');
        }

         /** @test */
         public function Gues_cannot_view_a_singgel_project()
         {
            $project =Project::factory()->create();
             $this->get($project->path())->assertRedirect('login');
         }
    
    /** @test */
    public function it_can_create_project()     
    {
        $this->actingAs(User::factory()->create());
        $attributes = [
            'title' =>$this->faker->name,
            'descriptions' =>$this->faker->paragraph,
            
        ];

        $this->post('/projects',$attributes)
        ->assertRedirect('/projects');
     
        $this->assertDatabaseHas('projects',$attributes);

        $this->get('/projects')->assertSee('title');
    }

    /** @test */
    public function project_require_a_title()
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['title'=> '']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function project_require_a_descriptions()
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['descriptions'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('descriptions');
    }

    /** @test */
    public function project_require_an_owner()
    {
        // $this->withoutExceptionHandling();
        $attributes = Project::factory()->raw();
        $this->post('/projects',$attributes)->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->be(User::factory()->create());
       
        // $this->withoutExceptionHandling();
        $project = Project::factory()->create(['owner_id' => \auth()->id()]);
        $this->get($project->path())
        ->assertSee($project->title)
        ->assertSee($project->descriptions);
    }

       /** @test */
       public function un_autenticated_user_cannot_view_their_project_of_other()
       {
           $this->be(User::factory()->create());
          
   
           $project = Project::factory()->create();
   
           $this->get($project->path())
           ->assertStatus(403);
           
       }
}
