<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Configuration;


class UserTest extends TestCase


{
        use RefreshDatabase;

        public function setUp():void
        {
            parent::setUp();
            $this->artisan('db:seed --class=RoleSeeder');
            $this->user=User::factory()->create(['role_id'=>1]);
        }

        public function test_user_can_not_create_a_configuration()
        {
            $response = $this->actingAs($this->user)->post('/configurations',[
                'name'=>'another discount',
                'value'=>3.03
            ]);
            $response->assertStatus(403);
            $this->assertTrue(Configuration::all()->count() == 0);
        }

        public function test_user_can_not_change_a_configuration()
        {
            $configuration=Configuration::factory()->create([
                'name'=>'loyalty_discount',
                'value'=>10.2
            ]);
            $this->assertDatabaseHas('configurations',['name'=>'loyalty_discount','value'=>10.2]);
            $response=$this->actingAs($this->user)->put('/configurations/'.$configuration->id,[
                'name'=>'loyalty_discount',
                'value'=>5.5
            ]);
            $response->assertStatus(403);
            $this->assertDatabaseHas('configurations',['name'=>'loyalty_discount','value'=>10.2]);

        }

        public function test_user_can_not_change_user_role()
        {
            $user=User::factory()->create([
                'name'=>'hugues',
                'id'=>3,
            ]);
            $this->assertDatabaseHas('users',['name'=>'hugues','role_id'=>1]);
            $response=$this->actingAs($this->user)->put('/users/'.$user->id,[
                'role_id'=>2
            ]);
            $response->assertStatus(403);
            $this->assertDatabaseHas('users',['name'=>'hugues','role_id'=>1]);
        }
    
    }
