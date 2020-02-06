<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test if user can see the login page.
     *
     * @test
     *
     * @return void
     */
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * Test if authenticated user can't see the login page.
     *
     * @test
     *
     * @return void
     */
    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    /**
     * Test if user can login.
     *
     * @test
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test if email exists.
     *
     * @test
     *
     * @return void
     */
    public function test_if_user_email_exists()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'testtest'),
        ]);

        $response = $this->post('/checkemail', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'exists' => true,
        ]);
    }
}
