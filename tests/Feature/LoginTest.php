<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
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
     * Login test.
     *
     * @return void
     */
    public function test_a_successful_login_response()
    {
        $data             = $this->data;
        $data['password'] = bcrypt($data['password']);

        User::query()->create($data);

        $response = $this->post(
            '/api/login',
            [
                'email'    => $data['email'],
                'password' => $this->data['password'],
            ]
        );

        $response->assertJson([
                                  'success' => true,
                              ]);
        $response->assertStatus(200);
    }

    /**
     * Check if the email is invalid
     *
     * @return void
     */
    public function test_not_registered_login_response()
    {
        $data     = $this->data;
        $response = $this->post(
            '/api/login',
            [
                'email'    => $data['email'],
                'password' => $data['password'],
            ]
        );

        $response->assertJson([
                                  'success' => false,
                                  'errors'  => ['email' => ['Email is not registered']],
                              ]);
        $response->assertStatus(422);
    }
}
