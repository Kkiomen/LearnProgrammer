<?php

namespace App\Http\Controllers;

use App\Api\Qdrant\Qdrant;
use App\Api\Qdrant\Search\SearchRequest;
use App\Api\Qdrant\Vector\VectorText;
use App\Class\LongTermMemory;
use App\Class\LongTermMemoryQdrant;
use App\CoreAssistant\Adapter\Entity\Conversation\ConversationRepository;
use App\CoreAssistant\Adapter\Entity\Message\MessageEloquentRepository;
use App\CoreAssistant\Adapter\Entity\Message\MessageRepository;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Api\OpenAiApi;
use App\CoreAssistant\DeclarationClass\Events\ListOrderEvent;
use App\CoreAssistant\Domain\Conversation\Conversation;
use App\CoreAssistant\Domain\Message\Message;
use App\CoreAssistant\Dto\MessageProcessor\MessageProcessor;
use App\CoreAssistant\Enum\OpenAiModel;
use App\CoreAssistant\Prompts\CreateHeaderTablePrompt;
use App\CoreAssistant\Service\Interfaces\MessageFacadeInterface;
use App\CoreAssistant\Service\Message\ConversationService;
use App\CoreAssistant\Service\Message\MessageFacade;
use App\Enum\QuizType;
use App\Jobs\ComplaintGenerate;
use App\Models\QuizQuestion;
use App\Prompts\ComplaintPromptHelper;
use App\Prompts\GenerateQuestionToQuizPromptHelper;
use App\Prompts\SelectOrderPrompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenAI\Client;
use Illuminate\Support\Facades\File;

class TestController
{
//    private Client|null $client = null;
//    private LongTermMemoryQdrant $longTermMemory;
//    private OpenAiApi $openAiApi;
//    private Qdrant $qdrant;
//
//    public function __construct(LongTermMemoryQdrant $longTermMemory, Qdrant $qdrant, OpenAiApi $openAiApi)
//    {
//        $this->client = $this->getClient();
//        $this->longTermMemory = $longTermMemory;
//        $this->qdrant = $qdrant;
//        $this->openAiApi = $openAiApi;
//    }

    public function __construct(
        private readonly MessageFacade $messageFacade,
        private readonly OpenAiApi $openAiApi,
        private readonly ConversationRepository $repository,
        private readonly ListOrderEvent $listOrderEvent,
        private readonly ConversationService $conversationService,
        private readonly LanguageModel $languageModel
    )
    {
    }

    public function test(Request $request)
    {

        dd(DB::connection('firebird')->select('SELECT * FROM CLIENTS'));


//        dd($this->repository->findAllMessages('d1ce2a50-24a3-44f4-9b30-0aec2878600f'));
//
//
//
//        $messageProcessor = new MessageProcessor();
//        $messageProcessor->setMessageFromUser('Jakie id ma produkt Talerz obiadowy głęboki 23 cm biały kwadrat?');
//        $messageProcessor->setSessionHash('d1ce2a50-24a3-44f4-9b30-0aec2878600f');
//
//        $this->messageFacade->loadMessageProcessor($messageProcessor);
//        $this->messageFacade->processAndReturnResponse();
//
//        $messageProcessor = new MessageProcessor();
//        $messageProcessor->setMessageFromUser('Jaki klient dokonał najwięcej zamówień?');
//        $messageProcessor->setSessionHash('d1ce2a50-24a3-44f4-9b30-0aec2878600f');
//
//        $this->messageFacade->loadMessageProcessor($messageProcessor);
//        $this->messageFacade->processAndReturnResponse();
//
//
////        $message = $this->conversationService->createMessage($messageProcessor);
//        dd('done');
//
//        $conversation = new Conversation();
//        $conversation->setSessionHash('d1ce2a50-24a3-44f4-9b30-0aec2878600f');
//
//        $d = $this->repository->save($conversation);
//
//        dump($d);

//        $messageProcessor = new MessageProcessor();
//        $messageProcessor->setMessageFromUser('Podaj w formie tabeli imię oraz nazwisko klientów którzy złożyli 3 ostatnie zamówienia');
//        $result = $this->listOrderEvent->handle($messageProcessor);
//
//        dd($result);
//        $repo = new MessageEloquentRepository();
//        /** @var Message $model */
//        $model = $this->repository->findById(4);
//        $model->setUserId(56);
//
//        $this->repository->save($model);
//
//        dump($this->repository->findById(4));


//        $messageProcessor = new MessageProcessor();
//        $messageProcessor->setMessageFromUser('Czy dzisiaj cokolwiek zakupiła u nas Chmielewska?');
//
//        $this->messageFacade->loadMessageProcessor($messageProcessor);
//
//        $this->messageFacade->processAndReturnResponse();

//        $system = SelectOrderPrompt::getPrompt();
//        $message = 'Ile klient "RAWPOL" wydał w tym roku?';




//        $sql = "SELECT id, company_address
//FROM combo_orders
//ORDER BY created_at DESC
//LIMIT 15;";
//
//        $result = DB::select(DB::raw($sql));
//
//        $resultJson = json_encode($result);
//        echo $resultJson;
//
//
//        $message = json_encode($result[0]);
//        $system = CreateHeaderTablePrompt::getPrompt($sql);
//
//        $header =  $this->openAiApi->completionChat(
//            message: $message,
//            systemPrompt: $system,
//            model: OpenAiModel::CHAT_GPT_3
//        );
//
//        $table = [];
//
//        $table[] = json_decode($header, true)[0];
//        $table = array_merge($table, $result);
//
//        dd(json_encode($table));










//        $handmade = false;
//
//        $errors = [];
//        $success = 0;
//        $failed = 0;
//
//        for($i = 0; $i <= 30; $i++){
//            try{
//                $designPatterns = GenerateQuestionToQuizPromptHelper::getDesignPatterns();
//                $randomIndex = array_rand($designPatterns);
//                $chooseDesignPattern = $designPatterns[$randomIndex];
//
//                $listCurrentQuiz = [];
//                $savedQuizWithThisPattern = QuizQuestion::where('correct_answer', $chooseDesignPattern)->get();
//
//                foreach ($savedQuizWithThisPattern as $quiz){
//                    $listCurrentQuiz[] = substr($quiz->question, 0, 30);;
//                }
//
//                $prompt = GenerateQuestionToQuizPromptHelper::getPrompt($chooseDesignPattern, $listCurrentQuiz);
//
//                if($handmade){
//                    echo $prompt;
//                    dd($prompt, GenerateQuestionToQuizPromptHelper::generateOptions($chooseDesignPattern), $chooseDesignPattern);
//                }else{
//
//                    /** @var OpenAiApi $openAiApi */
//                    $openAiApi = app(OpenAiApi::class);
//                    $json = $openAiApi->completionChat($prompt);
//                    echo $json;
//                    $json = GenerateQuestionToQuizPromptHelper::stripJsonMarkdown($json);
//
//                    $quizJson = json_decode($json, true);
//
//
//                    if (json_last_error() !== JSON_ERROR_NONE) {
//                        throw new \Exception(json_last_error_msg() . ' ' . $json);
//                    }
//
//                    if ($quizJson === null) {
//                        throw new \Exception('Zawartość JSON jest pusta lub nieprawidłowa');
//                    }
//
//
//                    $quizJson['options'] = GenerateQuestionToQuizPromptHelper::generateOptions($chooseDesignPattern);
//                    $quizJson['correctAnswer'] = $chooseDesignPattern;
//
//                    $quiz = new QuizQuestion();
//                    $quiz->type = QuizType::DESIGN_PATTERN->value;
//                    $quiz->lang = 'pl';
//                    $quiz->question = $quizJson['question'];
//                    $quiz->options = $quizJson['options'];
//                    $quiz->correct_answer = $quizJson['correctAnswer'];
//                    $quiz->explanation = $quizJson['explanation'];
//
//                    $quiz->save();
//                    $success++;
//                }
//
//            }catch (\Exception $e){
//                $errors[] = $e->getMessage();
//                $quiz = new QuizQuestion();
//                $failed ++;
//            }
//        }
//
//
//        echo '<h1>' . $success .' / ' . $failed . '</h1>';
//        dd($errors, $quiz);
//









//        /**
//         * @var ConversationRepository $convRepo
//         */
//        $convRepo = app(ConversationRepository::class);
//
//        dump($convRepo->getMessagesBySessionHash('d1ce2a50-24a3-44f4-9b30-0aec2878600f'));
//
//        ComplaintGenerate::dispatch('[SUMMARY]:
//Przedmiot reklamacji: Słuchawki Airpods Pro
//Opis reklamacji: Słuchawki nie ładują się pomimo działającego kabla ładowania. Słuchawki nie reagują na ładowanie, jednak kabel ładowania działa poprawnie na innych urządzeniach.
//Przewidywany czas rozpatrzenia reklamacji: Do 3 tygodni od momentu zgłoszenia reklamacji.
//Wynik reklamacji: Wymiana na nowy egzemplarz słuchawek Airpods Pro.');


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
