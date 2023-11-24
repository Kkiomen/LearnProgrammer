<?php

namespace App\Http\Controllers\Api;

use App\Enum\SnippetType;
use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Services\SnippetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SnippetController extends Controller
{

    private SnippetService $snippetService;

    /**
     * @param SnippetService $snippetService
     */
    public function __construct(SnippetService $snippetService)
    {
        $this->snippetService = $snippetService;
    }

    public function getSnippets(Request $request, $avatar)
    {
        return response()->json(Snippet::getSnippets($avatar));
    }

    public function getSnippetsSettings()
    {
        return response()->json($this->snippetService->getSnippetToModify());
    }

    public function getSnippet($id)
    {
        $snippet = Snippet::where('id', $id)->first();
        if (Snippet::hasPermissionToModify($snippet)) {
            return response()->json([
                'status' => 'success',
                'response' => [
                    'name' => $snippet->name,
                    'prompt' => $snippet->prompt,
                    'type' => $snippet->type,
                    'webhook' => $snippet->webhook ?? '',
                    'id' => $snippet->id
                ]
            ]);
        }
        return response()->json([
            'status' => 'danger',
            'message' => 'You dont have permissions'
        ]);
    }

    public function deleteSnippet($id)
    {
        $snippet = Snippet::where('id', $id)->first();
        if ($snippet && Snippet::hasPermissionToModify($snippet)) {
            if ($snippet->delete()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Correctly removed snippet'
                ]);
            } else {
                return response()->json([
                    'status' => 'danger',
                    'message' => 'An error has occurred, snippets can only be removed by the authors'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'danger',
                'message' => 'An error has occurred, snippets can only be removed by the authors or snippet does not exist'
            ]);
        }
    }

    public function addSnippet(Request $request)
    {
        $payload = $request->all();
        $status = $this->snippetService->saveSnippet(
            $payload['id'] ?? null,
            $payload['name'],
            $payload['prompt'],
            SnippetType::fromString($payload['type']),
            $payload['webhook'] ?? null
        );

        return response()->json($status);
    }
}
