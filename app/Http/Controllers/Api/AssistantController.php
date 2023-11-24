<?php

namespace App\Http\Controllers\Api;

use App\Core\Core\Helper\ResponseHelper;
use App\Services\AssistantService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AssistantController extends Controller
{


    public function __construct(
        private readonly AssistantService $assistantService,
        private readonly ResponseHelper $responseHelper
    )
    {
    }

    public function getAssistantInfo(int $assistantId){
        $assistant = $this->assistantService->getById($assistantId);

        return $this->responseHelper->responseJSON([
            'name' => $assistant?->getName(),
            'img' => $assistant?->getImgUrl(),
            'start_message' => $assistant?->getStartMessage(),
            'type' => $assistant?->getType()?->value,
        ]);
    }
}
