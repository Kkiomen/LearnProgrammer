<?php

namespace App\Http\Controllers\Api;
use App\CoreAssistant\Service\Message\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class SessionController
{
    public function __construct(
        private SessionService $sessionService
    ){}

    public function generateSession(Request $request): JsonResponse
    {
        return response()->json([
            'session_hash' => $this->sessionService->generateSession()
        ]);
    }
}
