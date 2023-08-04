<?php

namespace App\Snippets;

use App\Abstract\Snippet;
use App\Class\LongTermMemoryQdrant;
use App\Helpers\ApiHelper;

class SaveInformationSnippet extends Snippet
{
    public function getName(): string
    {
        return 'save-long-term';
    }

    /**
     * @throws \Exception
     */
    public function resultSnippet($message): string
    {
        /**
         * @var LongTermMemoryQdrant $longTerm
         */
        $longTerm = app(LongTermMemoryQdrant::class);

        if($longTerm->save($message)){
            return 'The data was saved';
        }else{
            return 'I was not able to save the data';
        }
    }

    public function canDisplaySnippet(): bool
    {
        return ApiHelper::canUseMemoryTerm();
    }
}
