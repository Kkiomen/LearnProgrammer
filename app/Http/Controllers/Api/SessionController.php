<?php

namespace App\Http\Controllers\Api;
use App\Core\Helper\ResponseHelper;
use App\Services\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class SessionController
{


    public function __construct(
        private readonly SessionService $sessionService,
        private readonly ResponseHelper $responseHelper,
    )
    {
    }

    public function generateSession(Request $request): JsonResponse
    {
        return $this->responseHelper->responseJSON(
            [
                'session_hash' => $this->sessionService->generateSession()
            ]
        );
    }
}
