<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Helpers\CreatePromptHelper;
use Illuminate\Http\Request;
use Throwable;

class GeminiAIService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com/',
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function generateAIResponse(string $data)
    {
        try {
            $response = $this->client->post(
                'v1beta/models/gemini-2.5-flash:generateContent',
                [
                    'query' => [
                        'key' => env('GEMINI_API_KEY')
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $data
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            );

            return json_decode(
                $response->getBody()->getContents(),
                true
            );
        } catch (Throwable $th) {
            return $th->getMessage();
        }
    }

    public function generateMarketingMessage(Request $request)
    {   
        $prompt = CreatePromptHelper::generateMarketingPlanCustomPrompt($request);
        return $this->generateAIResponse($prompt);
    }
}
