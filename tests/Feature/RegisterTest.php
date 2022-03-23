<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private array $data = [];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->data = [
            'name'     => 'John Doe',
            'email'    => 'test@mail.com',
            'phone'    => '+6281353672767',
            'password' => 'secret1234',
        ];
        parent::__construct($name, $data, $dataName);
    }

    /**
     *  Register a new user with valid data
     *
     * @return void
     */
    public function test_a_successful_registration_response()
    {
        $data     = $this->data;
        $response = $this->post(
            '/api/register',
            $data
        );


        $response->assertJson([
                                  'success' => true,
                              ]);
        $response->assertStatus(200);
    }

    /**
     * Check if the user is registered
     *
     * @return void
     */
    public function test_same_unique_data_registration_response()
    {
        $data = $this->data;
        User::query()->create($data);

        $response = $this->post(
            '/api/register',
            $data
        );

        $response->assertJson([
                                  'success' => false,
                                  'errors'  => ['email' => ['The email has already been taken.']],
                              ]);
        $response->assertStatus(422);
    }

    /**
     * Check if the email is invalid
     *
     * @return void
     */
    public function test_invalid_email_registration_response()
    {
        $data          = $this->data;
        $data['email'] = 'invalid Emailtest';
        $response      = $this->post(
            '/api/register',
            $data
        );

        $response->assertJson([
                                  'success' => false,
                                  'errors'  => ['email' => ['The email must be a valid email address.']],
                              ]);
        $response->assertStatus(422);
    }
}
