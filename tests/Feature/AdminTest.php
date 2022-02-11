<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Configuration;


class AdminTest extends TestCase
{
    use refreshDatabase;
    public function setUp():void
    {
        parent::setUp();
        $this->artisan('db:seed --class=RoleSeeder');
        $this->admin=User::factory()->create(['role_id'=>2]);
    }

    public function test_admin_can_create_a_configuration()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->admin)->post('/configurations',[
            'name'=>'another discount',
            'value'=>3.03
        ]);
        $response->assertStatus(200);
        $this->assertTrue(Configuration::all()->count() == 1);
    }

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


}
