<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\GenerateMarketingMessageUseCase;

class GeminiAIController extends Controller
{
    public function __construct(private GenerateMarketingMessageUseCase $generateMarketingMessageUseCase) {}

    public function createMarketingCustomPlan(Request $request)
    {
        return $this->generateMarketingMessageUseCase->execute($request);
    }
}
