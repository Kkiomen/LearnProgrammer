<?php

namespace App\Http\Controllers;

use App\Class\Assistant\Enum\AssistantType;
use App\Class\Assistant\Repository\AssistantRepository;
use App\Class\LongTermMemoryQdrant;
use App\Models\Assistant;
use App\Models\LongTermMemoryContent;
use App\Services\AssistantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AssistantController extends Controller
{


    public function __construct(
        private readonly AssistantService $assistantService
    )
    {
    }

    public function listAssistant(){
        $assistants = $this->assistantService->allAssistants();
        return view('pages/assistant/list', [
            'assistants' => $assistants
        ]);
    }

    public function assistantMemory($assistantId){
        $assistant = $this->assistantService->getById($assistantId);
        if(!$assistant){
            return abort(404);
        }
        $memories = $this->assistantService->getAssistantMemory($assistant);
        return view('pages/assistant/memory', [
            'assistant' => $assistant,
            'memories' => $memories
        ]);
    }

    public function assistantMemoryAdd(Request $request){
        $request->validate([
            'content' => 'required',
            'assistantId' => 'required',
        ]);

        $assistant = Assistant::find($request->get('assistantId'));

        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        $longTermMemoryQdrant->save($request->get('content'), null, $assistant->memory_collection);

        $longTermMemory = LongTermMemoryContent::where('content', $request->get('content'))->first();
        $longTermMemory->link = $request->get('link');
        $longTermMemory->assistant_id = $request->get('assistantId');
        $longTermMemory->type = $request->get('type') ?? 'TEXT';
        $longTermMemory->save();

        return Redirect::back()->with('success', 'Pomyślnie zapisano informacje');

    }

    public function assistantMemoryRemove(int $assistantId, $id): RedirectResponse
    {

        $assistant = Assistant::find($assistantId);
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        if($longTermMemoryQdrant->remove($id, $assistant->memory_collection)){
            return Redirect::back()->with('success', 'Pomyślnie usunięto informacje');
        }

        return Redirect::back()->with('danger', 'Wystąpił problem podczas usuwania elementu z pamięci');
    }

    public function editAssistant(int $assistantId){
        $assistant = $this->assistantService->getById($assistantId);
        if(!$assistant){
            return abort(404);
        }


        return view('pages/assistant/edit', [
            'assistant' => $assistant,
            'types' => AssistantType::toArray()
        ]);
    }

    public function saveAssistant(Request $request, int $assistantId): RedirectResponse
    {
        $assistant = $this->assistantService->getById($assistantId);
        if(!$assistant){
            return abort(404);
        }

        $request->validate([
            'name' => 'required',
            'prompt' => 'required',
        ]);

        $assistant->setName($request->get('name') ?? null);
        $assistant->setImgUrl($request->get('img_url'));
        if($assistant->getPromptHistory()->getPrompt() !== $request->get('prompt')){
            $assistant->getPromptHistory()->setPrompt($request->get('prompt') ?? null);
        }
        $assistant->setPublic($request->get('public') == 'true');
        $assistant->setSort($request->get('sort'));
        $assistant->setType(AssistantType::from($request->get('type')));
        $this->assistantService->save($assistant);


        return Redirect::back()->with('success', 'Pomyślnie zaaktualizowano informacje');
    }
}
