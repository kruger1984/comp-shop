<?php

declare(strict_types=1);

//namespace Auth\Actions;
namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'testing@mail.ru'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test', 'testing@mail.ru', '1234567890'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing@mail.ru'
        ]);
    }
}
