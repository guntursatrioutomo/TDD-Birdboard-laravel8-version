<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
   /** @test */
   public function a_user_has_project()
   {
       $user = User::factory()->create();

       $this->assertInstanceOf(Collection::class, $user->projects);
   }
}
