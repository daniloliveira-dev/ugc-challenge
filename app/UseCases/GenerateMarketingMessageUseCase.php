<?php

namespace App\UseCases;

use App\Services\GeminiAIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateMarketingMessageUseCase
{
    private GeminiAIService $geminiAI;

    public function __construct(GeminiAIService $geminiAI)
    {
        $this->geminiAI = $geminiAI;
    }

    public function execute(Request $request): JsonResponse
    {
        try {
            $result = $this->geminiAI->generateMarketingMessage($request);

            $text = null;
            if (is_array($result) && isset($result['candidates']) && is_array($result['candidates']) && count($result['candidates']) > 0) {
                $candidate = $result['candidates'][0];
                if (isset($candidate['content']['parts']) && is_array($candidate['content']['parts']) && count($candidate['content']['parts']) > 0) {
                    $text = $candidate['content']['parts'][0]['text'] ?? null;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'text' => $text,
                    'raw' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Houve um erro ao tentar executar a operação',
                'error' => $e->getMessage()
            ]);
        }
    }
}
