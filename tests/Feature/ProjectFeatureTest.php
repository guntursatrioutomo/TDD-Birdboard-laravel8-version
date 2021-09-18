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
    public function it_can_show_project()
    {
        
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get($project->path())
        ->assertSee($project->title)
        ->assertSee($project->descriptions);
    }
}
