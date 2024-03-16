<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class VacationPlanTest extends TestCase
{
    use RefreshDatabase;
    
    private User $user;
    
    protected function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    /**
     * API registration endpoint test.
     */
    public function test_api_registration(): void
    {
        $response = $this->post('/api/register', [
            'name'=>'user1',
            'email'=>'user1@user1.com',
            'password'=>'123456',
            'password_confirmation'=>'123456'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    /**
     * API login endpoint test.
     */
    public function test_api_login(): void
    {

        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        // dd($response);
        $response->assertStatus(200);
        $response->assertJson([
            'Access_Token'
        ]);
        $this->assertAuthenticatedAs($this->user);
    }
}
