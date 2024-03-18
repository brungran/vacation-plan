<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use App\Models\VacationPlan;

class VacationPlanTest extends TestCase
{
    use RefreshDatabase;

    /* protected function setUp(): void{
        parent::setUp();

        $this->artisan('passport:client', [
            '--personal'=>true
        ])->expectsQuestion('What should we name the personal access client?', 'testing');
    } */

    private function create_passport_personal_client(): void{
        $this->artisan('passport:client', [
            '--personal'=>true
        ])->expectsQuestion('What should we name the personal access client?', 'testing');
    }

    private function create_user_with_token(){
        $user = User::factory()->create();
        $token = $user->createToken('token');
        return $token;
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
        
        $this->create_passport_personal_client();
        
        User::create([
            'name'=> 'name 1',
            'email'=> 'user1@user1.com',
            'password' => '123456',
            'password_confirmation'=>'123456'
        ]);
        
        $response = $this->post('/api/login', [
            'email' => 'user1@user1.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    /**
     * API show vacation plans endpoint test.
     */
    public function test_api_show_all_vacation_plans(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();
        /* $this->create_personal_client();
        $this->api_registration_endpoint_request();
        $token = $this->api_login_endpoint_request()->json()['Access_Token']; */

        VacationPlan::factory(5)->create();
        
        $response = $this->get('/api/vacationplans')->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    public function test_api_show_vacation_plan_by_id(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();

        VacationPlan::factory(5)->create();
        
        $response = $this->get('/api/vacationplans/1')->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    public function test_api_create_vacation_plan(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();

        $response = $this->post('/api/vacationplans/',[
            'title'=>'title 1',
            'description'=>'description 1',
            'date'=>'2024-06-12',
            'location'=>'location 1',
            'participants'=>'1',
        ])->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    public function test_api_update_vacation_plan(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();

        VacationPlan::factory(5)->create();
        
        $response = $this->put('/api/vacationplans/1',[
            'title'=>'title 2',
            'description'=>'description 2',
            'date'=>'2024-06-12',
            'location'=>'location 2',
            'participants'=>'2',
        ])->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    public function test_api_delete_vacation_plan(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();

        VacationPlan::factory(5)->create();
        
        $response = $this->delete('/api/vacationplans/1')->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'Successful'=>true
        ]);
    }

    public function test_api_generate_pdf(): void
    {
        
        $this->create_passport_personal_client();
        
        $token = $this->create_user_with_token();

        VacationPlan::factory(5)->create();
        
        $this->get('/api/vacationplans/1/pdf')->withHeaders([
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$token->accessToken
        ]);

        Pdf::assertRespondedWithPdf(function (PdfBuilder $pdf){
            return str_contains($pdf->html, 'Your Vacation Plan');
        });
    }
}
