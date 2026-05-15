<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $endpoint;

    public function __construct()
    {
        $this->apiKey   = config('services.gemini.key', '');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    }

    /**
     * Call the Gemini API and return the generated text, or null on failure.
     */
    public function generate(string $systemPrompt, array $contents, int $maxTokens = 1024, float $temperature = 0.7): ?string
    {
        $response = Http::timeout(30)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->endpoint}?key={$this->apiKey}", [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'contents'         => $contents,
                'generationConfig' => [
                    'maxOutputTokens' => $maxTokens,
                    'temperature'     => $temperature,
                ],
            ]);

        if (!$response->successful()) {
            Log::error('Gemini API Error', [
                'status'      => $response->status(),
                'body'        => $response->body(),
                'key_present' => !empty($this->apiKey),
            ]);
            return null;
        }

        return $response->json('candidates.0.content.parts.0.text');
    }

    /**
     * Build a Gemini-compatible contents array from a conversation history
     * array (role/content pairs) plus the new user message.
     *
     * Maps 'assistant' → 'model' as Gemini requires.
     */
    public function buildContents(array $history, string $userMessage): array
    {
        $contents = [];

        foreach ($history as $h) {
            if (!isset($h['role'], $h['content'])) {
                continue;
            }
            $contents[] = [
                'role'  => $h['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $h['content']]],
            ];
        }

        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        return $contents;
    }

    /**
     * Build a single-turn contents array (no history) — used for
     * one-shot prompts like route suggestions.
     */
    public function buildSingleTurn(string $userMessage): array
    {
        return [
            [
                'role'  => 'user',
                'parts' => [['text' => $userMessage]],
            ],
        ];
    }
}
