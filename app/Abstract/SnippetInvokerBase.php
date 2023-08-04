<?php

namespace App\Abstract;

use InvalidArgumentException;

abstract class SnippetInvokerBase
{

    private $snippets;

    public function __construct()
    {
        $this->snippets = [];
        $this->registerSnippets();
    }

    /**
     * Register new Snippet
     * @param string $snippetClass
     * @return void
     */
    protected function registerSnippet(string $snippetClass): void
    {
        $snippet = new $snippetClass;
        if ($snippet instanceof Snippet){
            $this->snippets[$snippet->getName()] = $snippet;
        } else {
            throw new InvalidArgumentException("Class {$snippetClass} must inherit from the Snippet class.");
        }
    }

    /**
     * Execute Snippet
     * @param string $snippetName
     * @param string $prompt
     * @return string|null
     */
    public function executeSnippet(string $snippetName, string $prompt): ?array
    {
        if(isset($this->snippets[$snippetName])){
            $snippet = $this->snippets[$snippetName];
            return $snippet->execute($prompt);
        } else {
            return null;
        }
    }

    /**
     * Check if a Snippet with a given name can be displayed.
     * @param string $snippetName Name of the Snippet to check.
     * @return bool Returns true if the Snippet can be displayed, false otherwise.
     */
    public function canDisplaySnippet(string $snippetName): bool
    {
        if(isset($this->snippets[$snippetName])){
            $snippet = $this->snippets[$snippetName];
            return $snippet->canDisplaySnippet();
        }

        return true;
    }

    /**
     * The method is used to record Snippet
     * @return void
     */
    abstract function registerSnippets(): void;
}
