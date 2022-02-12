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
        $response = $this->actingAs($this->admin)->post('/configurations',[
            'name'=>'another discount',
            'value'=>3.03
        ]);
        $response->assertStatus(200);
        $this->assertTrue(Configuration::all()->count() == 1);
    }

    public function test_admin_can_change_a_configuration()
    {
        $configuration=Configuration::factory()->create([
            'name'=>'loyalty_discount',
            'value'=>10.2
        ]);
        $this->assertDatabaseHas('configurations',['name'=>'loyalty_discount','value'=>10.2]);
        $response=$this->actingAs($this->admin)->put('/configurations/'.$configuration->id,[
            'name'=>'loyalty_discount',
            'value'=>5.5
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('configurations',['name'=>'loyalty_discount','value'=>5.5]);

    }


}
