<?php

namespace App\Http\Controllers\Api;

use App\Enum\QuizType;
use App\Models\QuizQuestion;
use App\Prompts\GenerateQuestionToQuizPromptHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuizDesignPatternController extends Controller
{
    public function __construct(
    )
    {
    }

    public function getNewQuestion(Request $request): JsonResponse{



//        $quiz = new QuizQuestion();
//        $quiz->type = QuizType::DESIGN_PATTERN->value;
//        $quiz->lang = 'pl';
//        $quiz->question = 'Masz za zadanie zaprojektować system logowania dla aplikacji internetowej, który umożliwia różnym metodom autentykacji (np. hasło, odcisk palca, rozpoznawanie twarzy) być łatwo dodawanymi lub modyfikowanymi bez zmiany istniejącego kodu systemu. Który wzorzec projektowy najlepiej pasuje do tego scenariusza?';
//        $quiz->options = ["Wzorzec Singleton", "Wzorzec Fabryka Abstrakcyjna", "Wzorzec Strategia", "Wzorzec Dekorator"];
//        $quiz->correct_answer = "Wzorzec Strategia";
//        $quiz->explanation = '';
//        $quiz->save();

        $quiz = QuizQuestion::where('lang', 'pl')->get()->random();

        return response()->json([
            'question' => $quiz->question,
            'options' => GenerateQuestionToQuizPromptHelper::generateOptions($quiz->correct_answer) ?? $quiz->options,
            'correctAnswer' => $quiz->correct_answer,
            'explanation' => $quiz->explanation
        ]);

    }
}
