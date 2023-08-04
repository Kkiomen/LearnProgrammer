<?php

namespace App\Services;


use App\Abstract\SnippetInvokerBase;
use App\Snippets\AutomaticTestOpenaiSnippet;
use App\Snippets\SaveInformationSnippet;

class SnippetInvoker extends SnippetInvokerBase
{

    /**
     * Register all Snippets
     * @return void
     */
    function registerSnippets(): void
    {
        $this->registerSnippet(SaveInformationSnippet::class);
        $this->registerSnippet(AutomaticTestOpenaiSnippet::class);
    }

}
