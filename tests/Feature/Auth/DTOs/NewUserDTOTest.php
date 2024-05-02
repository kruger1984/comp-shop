<?php

declare(strict_types=1);

namespace Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\app\Http\Controllers\Auth\SignUpControllerTest;
use Tests\TestCase;

final class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_instance_created_from_formrequest(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test@mail.ru',
            'password' => '12345'
        ]));
        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }


}
