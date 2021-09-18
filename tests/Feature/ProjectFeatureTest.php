<?php

namespace Tests\Feature;

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
        $attributes = [
            'title' =>$this->faker->name,
            'descriptions' =>$this->faker->paragraph,
        ];

        $this->post('/projects',$attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects',$attributes);

        $this->get('/projects')->assertSee('title');
    }

    /** @test */
    public function project_require_a_title()
    {
        $this->post('/projects',[])->assertSessionHasErrors('title');
    }

    /** @test */
    public function project_require_a_descriptions()
    {
          $this->post('/projects',[])->assertSessionHasErrors('descriptions');
    }
}
