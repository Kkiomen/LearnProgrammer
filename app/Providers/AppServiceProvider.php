<?php

namespace App\Providers;

use App\CoreAssistant\Adapter\Entity\Conversation\ConversationEloquentRepository;
use App\CoreAssistant\Adapter\Entity\Conversation\ConversationRepository;
use App\CoreAssistant\Adapter\Entity\Message\MessageEloquentRepository;
use App\CoreAssistant\Adapter\Entity\Message\MessageRepository;
use App\CoreAssistant\Adapter\LLM\LanguageModel;
use App\CoreAssistant\Adapter\LLM\models\OpenAi\OpenAiLanguageModel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Repository
        $this->app->bind(MessageRepository::class, MessageEloquentRepository::class);
        $this->app->bind(ConversationRepository::class, ConversationEloquentRepository::class);

        // Language Model
        $this->app->bind(LanguageModel::class, OpenAiLanguageModel::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
