<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class VacationPlanTest extends TestCase
{
    use RefreshDatabase;
    private function create_personal_client(): void{
        $this->artisan('passport:client', [
            '--personal'=>true
        ])->expectsQuestion('What should we name the personal access client?', 'testing');
    }

    private function api_registration_endpoint_request(){

        return $this->post('/api/register', [
            'name'=>'user1',
            'email'=>'user1@user1.com',
            'password'=>'123456',
            'password_confirmation'=>'123456'
        ]);
    }

    private function api_login_endpoint_request(){

        return $this->post('/api/login', [
            'email' => 'user1@user1.com',
            'password' => '123456',
        ]);
    }

    /**
     * API registration endpoint test.
     */
    public function test_api_registration(): void
    {
        $response = $this->api_registration_endpoint_request();

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
        
        $this->create_personal_client();
        $this->api_registration_endpoint_request();
        
        $response = $this->api_login_endpoint_request();

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    /**
     * API show vacation plans endpoint test.
     */
    public function test_api_show_vacation_plans(): void
    {
        
        $this->create_personal_client();
        $user = User::factory()->create();
        $token = $user->createToken('token');
        /* $this->create_personal_client();
        $this->api_registration_endpoint_request();
        $token = $this->api_login_endpoint_request()->json()['Access_Token']; */

        $response = $this->post('/api/vacationplans')->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);
        dd($response);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }
}
