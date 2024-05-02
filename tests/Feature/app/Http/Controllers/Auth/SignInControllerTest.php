<?php

namespace Tests\Feature\app\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Requests\SignInFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @return void
     */
    public function it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
             ->assertOk()
             ->assertSee('Вход в аккаунт')
             ->assertViewIs('auth.login');
    }

    /**
     * @test
     * @return void
     */
    public function it_handle_success():void
    {
        $password = '123456789';
        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password
        ]);
        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }
    /**
     * @test
     * @return void
     */
    public function it_handle_fail():void
    {
        $request = SignInFormRequest::factory()->create([
            'email' => 'notfound@mail.ru',
            'password' => str()->random(10)
        ]);
        $this->post(action([SignInController::class, 'handle']), $request)->assertInvalid(['email']);

        $this->assertGuest();
    }
    /**
     * @test
     * @return void
     */
    public function it_logout_success(): void
    {
        $user = UserFactory::new()->create(['email' => 'testing@mail.ru',]);

        $this->actingAs($user)->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_quest_middleware_fail(): void
{
    $this->delete(action([SignInController::class, 'logOut']))->assertRedirect(route('home'));
}

}
