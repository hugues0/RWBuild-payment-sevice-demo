<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;


class SuperAdminTest extends TestCase
{
    use refreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->super_admin=User::factory()->create(['role_id'=>3]);
    }

    public function test_super_admin_can_update_user_role()
    {
        $user=User::factory()->create([
            'name'=>'hugues',
            'id'=>3,
        ]);
        $this->assertDatabaseHas('users',['name'=>'hugues','role_id'=>1]);
        $response=$this->actingAs($this->super_admin)->put('/users/'.$user->id,[
            'role_id'=>2
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['name'=>'hugues','role_id'=>2]);

    }

}
