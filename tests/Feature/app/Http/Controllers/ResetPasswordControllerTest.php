<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_displays_password_reset_page()
    {
        $token = 'sample_token'; // Замените этот токен на реальный токен
        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertStatus(200)
                 ->assertViewIs('auth.reset-password')
                 ->assertViewHas('token', $token);
    }

    /** @test */
    public function it_handles_password_reset_request()
    {
        // Создаем пользователя
        $user = UserFactory::new()->create();

        // Создаем токен для сброса пароля
        $token = Password::createToken($user);

        // Генерируем новый пароль
        $newPassword = $this->faker->password(10);

        // Отправляем запрос на сброс пароля
        $response = $this->post(route('password-reset.handle'), [
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => $token,
        ]);

        // Проверяем, что произошел редирект на страницу входа
        $response->assertRedirect(route('login'));

        // Проверяем, что в ответе есть сообщение об успешном сбросе пароля
        $response->assertSee('Password reset successfully');

        // Проверяем, что в ответе возвращены правильные данные
        $response->assertJson([
            'message' => 'Password reset successfully',
            'user' => $user->email
        ]);

        // Проверяем, что пароль пользователя был обновлен
        $this->assertTrue(password_verify($newPassword, $user->fresh()->password));
    }
}
