<?php

declare(strict_types=1);

//namespace Services\Telegram;
namespace Tests\Unit\Services\Telegram;


use Illuminate\Support\Facades\Http;
use Services\TelegramBotApi;
use Services\TelegramBotApiContract;
use Tests\TestCase;

final class TelegramBotApiTest extends TestCase
{
    /**
     * @test
     * @returns void
     */
    public function it_send_message_success_by_http_fake(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $result = TelegramBotApi::sendMessage('', 1,'Testing');

        $this->assertTrue($result);
    }
    /**
     * @test
     * @returns void
     */
    public function it_send_message_success_by_fake_instance(): void
    {
        TelegramBotApi::fake()->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

        $this->assertTrue($result);
    }

    /**
     * @test
     * @returns void
     */

    public function it_send_message_fail_by_fake_instance():void
    {
        TelegramBotApi::fake()->returnFalse();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing');

        $this->assertFalse($result);
    }
}
