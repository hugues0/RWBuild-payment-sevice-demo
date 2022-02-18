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
        $this->artisan('db:seed --class=LaratrustSeeder');
        $this->super_admin=User::factory()->create()->attachRole(Role::IS_SUPER_ADMIN);
    }

    public function test_super_admin_can_update_user_role()
    {
        $user=User::factory()->create(['name'=>'Hugues'])->attachRole(Role::IS_USER);
        $this->assertDatabaseHas('users',['name'=>'Hugues']);
        $response=$this->actingAs($this->super_admin)->put('/users/'.$user->id,[
          'name'=>'Ntwari Hugues',
          'role'=>[Role::IS_ADMIN],
        ]);
        $response->assertStatus(200);
    }

}
