<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CloudController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProductDescriptionController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\SnippetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/quiz/design-pattern/question', [\App\Http\Controllers\Api\QuizDesignPatternController::class, 'getNewQuestion']);


Route::post('/message/new', [MessageController::class, 'newMessage']);
Route::post('/messages', [MessageController::class, 'getMessagesConversation']);
Route::post('/messages/clear', [MessageController::class, 'clearConversation']);
Route::get('/session', [SessionController::class, 'generateSession']);
Route::get('/assistant/{assistantId}', [\App\Http\Controllers\Api\AssistantController::class, 'getAssistantInfo']);

Route::middleware('auth:sanctum')->group(function () {




    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/avatars', [AvatarController::class, 'getAvatars']);
    Route::get('/avatar/{shortName}', [AvatarController::class, 'getAvatar']);
    Route::post('/user/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/user/update-api-key', [AuthController::class, 'updateApiKey']);

    Route::get('/chat/messages', [ChatController::class, 'getMessages']);
    Route::get('/chat/history', [ChatController::class, 'getHistory']);
    Route::get('/chat/conversation/{id}', [ChatController::class, 'getConversation']);
    Route::get('/chat/command-list', [ChatController::class, 'getCommandList']);
    Route::post('/chat/product-description', [ProductDescriptionController::class, 'prepareDescription']);
    Route::post('/chat/message', [ChatController::class, 'processMessage']);
    Route::get('/chat/clear', [ChatController::class, 'clearConversation']);

    Route::get('/snippets/{avatar}', [SnippetController::class, 'getSnippets']);
    Route::get('/snippets/to/modify', [SnippetController::class, 'getSnippetsSettings']);
    Route::get('/snippet/{id}', [SnippetController::class, 'getSnippet']);
    Route::delete('/snippet/{id}', [SnippetController::class, 'deleteSnippet']);
    Route::post('/snippet/add', [SnippetController::class, 'addSnippet']);

    Route::post('/add/group', [GroupController::class, 'addGroup']);
    Route::get('/groups', [GroupController::class, 'getGroups']);
    Route::put('/modify/group/user', [GroupController::class, 'addUser']);
    Route::get('/add/group/user/{group}/{id}', [GroupController::class, 'getUser']);
    Route::post('/delete/group/user', [GroupController::class, 'deleteUser']);

    Route::apiResource('/users', UserController::class);
    Route::post('/cloud/image/add', [CloudController::class, 'addImage']);
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
