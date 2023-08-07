<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CloudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('assistants', [\App\Http\Controllers\AssistantController::class, 'listAssistant'])->name('assistants');

Route::get('assistants/{assistantId}/edit', [\App\Http\Controllers\AssistantController::class, 'editAssistant'])
    ->name('assistant_edit')
    ->where('assistantId', '[0-9]+');
Route::post('assistants/{assistantId}/save', [\App\Http\Controllers\AssistantController::class, 'saveAssistant'])
    ->name('assistantSave');

Route::get('assistants/{assistantId}/memory', [\App\Http\Controllers\AssistantController::class, 'assistantMemory'])
    ->name('assistants_memory')
    ->where('assistantId', '[0-9]+');
Route::post('assistant/memory/new', [\App\Http\Controllers\AssistantController::class, 'assistantMemoryAdd'])->name('assistantMemoryAdd');
Route::get('assistant/{assistantId}/memory/remove/{id}', [\App\Http\Controllers\AssistantController::class, 'assistantMemoryRemove'])->name('assistantMemoryRemove');


Route::get('cloud/{uuid}', [CloudController::class, 'show']);
Route::get('test', [\App\Http\Controllers\TestController::class, 'test']);
