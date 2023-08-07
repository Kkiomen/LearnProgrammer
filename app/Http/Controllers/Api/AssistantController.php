<?php

namespace App\Http\Controllers\Api;

use App\Core\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\AssistantService;
use Illuminate\Http\Request;

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
            'img' => $assistant?->getImgUrl()
        ]);
    }
}
