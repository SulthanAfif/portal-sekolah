<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_chat_uses_configured_gemini_model_and_returns_reply(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);
        config([
            'services.gemini.key' => 'configured-gemini-key',
            'services.gemini.model' => 'gemini-2.5-flash',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    ['content' => ['parts' => [['text' => 'Jadwal sekolah hari ini.']]]],
                ],
            ]),
        ]);

        $response = $this->actingAs($user)->postJson('/chatbot/chat', [
            'message' => 'Ada jadwal apa?',
        ]);

        $response->assertOk()->assertJsonPath('reply', 'Jadwal sekolah hari ini.');
        $response->assertSessionHas('chat_history', [
            ['role' => 'user', 'text' => 'Ada jadwal apa?'],
            ['role' => 'model', 'text' => 'Jadwal sekolah hari ini.'],
        ]);

        Http::assertSent(fn (ClientRequest $request): bool => $request->url() === 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent'
            && $request->hasHeader('x-goog-api-key', 'configured-gemini-key')
            && array_key_exists('systemInstruction', $request->data()));
    }

    public function test_chat_returns_a_friendly_message_when_gemini_rejects_the_request(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);
        config([
            'services.gemini.key' => 'configured-gemini-key',
            'services.gemini.model' => 'gemini-2.5-flash',
        ]);
        Http::preventStrayRequests();
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['message' => 'Model unavailable.'],
            ], 404),
        ]);

        $response = $this->actingAs($user)->postJson('/chatbot/chat', [
            'message' => 'pengumuman',
        ]);

        $response->assertOk()->assertJsonPath(
            'reply',
            'Maaf, saat ini asisten sedang mengalami gangguan. Silakan coba lagi nanti.'
        );
        $response->assertSessionMissing('chat_history');
    }

    public function test_chat_rejects_a_missing_message(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($user)->postJson('/chatbot/chat');

        $response->assertUnprocessable()->assertJsonValidationErrors('message');
    }
}
