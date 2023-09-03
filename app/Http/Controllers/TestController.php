<?php

namespace App\Http\Controllers;

use App\Api\OpenAiApi;
use App\Api\Qdrant\Qdrant;
use App\Api\Qdrant\Search\SearchRequest;
use App\Api\Qdrant\Vector\VectorText;
use App\Class\Conversation\Repository\ConversationRepository;
use App\Class\LongTermMemory;
use App\Class\LongTermMemoryQdrant;
use App\Jobs\ComplaintGenerate;
use App\Strategy\Message\MessageContext;
use Cscheide\ArticleExtractor\ArticleExtractor;
use Illuminate\Http\Request;
use OpenAI\Client;

class TestController
{
    private Client|null $client = null;
    private LongTermMemoryQdrant $longTermMemory;
    private OpenAiApi $openAiApi;
    private Qdrant $qdrant;

    public function __construct(LongTermMemoryQdrant $longTermMemory, Qdrant $qdrant, OpenAiApi $openAiApi)
    {
        $this->client = $this->getClient();
        $this->longTermMemory = $longTermMemory;
        $this->qdrant = $qdrant;
        $this->openAiApi = $openAiApi;
    }

    public function test(Request $request, MessageContext $messageContext)
    {
//        /**
//         * @var ConversationRepository $convRepo
//         */
//        $convRepo = app(ConversationRepository::class);
//
//        dump($convRepo->getMessagesBySessionHash('d1ce2a50-24a3-44f4-9b30-0aec2878600f'));

        ComplaintGenerate::dispatch('[SUMMARY]:
Przedmiot reklamacji: Słuchawki Airpods Pro
Opis reklamacji: Słuchawki nie ładują się pomimo działającego kabla ładowania. Słuchawki nie reagują na ładowanie, jednak kabel ładowania działa poprawnie na innych urządzeniach.
Przewidywany czas rozpatrzenia reklamacji: Do 3 tygodni od momentu zgłoszenia reklamacji.
Wynik reklamacji: Wymiana na nowy egzemplarz słuchawek Airpods Pro.');


//        foreach ($this->openAiApi->getModels()['data'] as $model){
//            echo $model['id'] . ' -> ' . $model['object'] . '<br/>';
//        }

//        dump($this->longTermMemory->save('Jako jeden z benefitów dajemy karte multisport i ubezpieczenie na życie'));
//        dump($this->longTermMemory->getMemory('Jakie benefity dajecie?'));
//        dump($this->qdrant->search(new SearchRequest(
//            vector: new VectorText(
//                openAiApi: $this->openAiApi,
//                text: 'Jakie benefity dajecie?'
//            ),
//            nameCollection: 'memory'
//        )));

//        $message = 'Endpoint: /api/admin/units/{unit_id} %%% Method: delete ### Information OpenApi: {"tags":["Units"],"operationId":"delete_wise_product_apiadmin_units_deleteunitsbykey_deleteunits","parameters":[{"name":"x-request-uuid","in":"header","description":"UUID requestu","schema":{"type":"string"},"example":"49c9aa13-c5c3-474b-a874-755f9d553779"},{"name":"unit_id","in":"path","required":true,"schema":{"type":"string","pattern":"([a-zA-Z0-9-_])+"}}],"responses":{"200":{"description":"Zwrotka w przypadku znalezionych i poprawienie usuniętych obiektów","content":{"application/json":{"schema":{"$ref":"#/components/schemas/CommonDeleteResponseAdminApiDto"}}}},"400":{"description":"Niepoprawne dane wejściowe","content":{"application/json":{"schema":{"$ref":"#/components/schemas/InvalidInputDataResponseDto"}}}},"401":{"description":"Błędny token autoryzacyjny","content":{"application/json":{"schema":{"$ref":"#/components/schemas/UnauthorizedResponseDto"}}}}}}';
//        $system = 'Return the answer in JSON and nothing else. Based on the user-provided information that comes from the OpenApi json, return a list in JSON of the most important test cases for the provided endpoint. Take into account strange situations , which can mess up the system
//Return only json and nothing else.
//
//###
//Return the answer in JSON and nothing else (example format}:
//[
//{
//     description:  (in the form of one sentence)
//},
//{
//     description:  (in the form of one sentence)
//}, ...
//]
//
//###
//Return only json and nothing else. ';
//
//        /**
//         * @var OpenAiApi $openApi
//         */
//        $openApi = app(OpenAiApi::class);
//        dd(json_decode($openApi->completionChat($message, $system), true));

    }



    private function getClient(): Client
    {
        return \OpenAI::client(getenv('OPEN_AI_KEY'));
    }
}
// Bądź bezpośrenia, konkretna i szczerze zainteresowana. Mów językiem naturalnym, tonem. Wyciągaj precyzyjne wnioski i posumuj rozmowe
//aby dowiedzieć się i zrozumieć, o czym własnie rozmawiają
