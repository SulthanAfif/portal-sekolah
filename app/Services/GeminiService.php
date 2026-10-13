<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function chat(string $message): string
    {
        $apiKey = config('services.gemini.key');
        $model  = config('services.gemini.model', 'gemini-1.5-flash');

        $systemPrompt = "Kamu adalah Asisten Virtual Portal Sekolah..."; // sama seperti di atas

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::post($url, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nPertanyaan: " . $message]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 500,
            ]
        ]);

        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada jawaban.';
    }
}
