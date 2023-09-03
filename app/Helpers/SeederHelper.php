<?php

namespace App\Helpers;

use App\Class\LongTermMemoryQdrant;
use App\Models\LongTermMemoryContent;

class SeederHelper
{

    public static function saveLongTermMemory(string $content, int $assistantId): void
    {
        /**
         * @var LongTermMemoryQdrant $longTermMemoryQdrant
         */
        $longTermMemoryQdrant = app(LongTermMemoryQdrant::class);
        if($longTermMemoryQdrant->save($content)){
            $longTermMemory = LongTermMemoryContent::where('content', $content)->first();
            $longTermMemory->assistant_id = $assistantId;
            $longTermMemory->tags = null;
            $longTermMemory->type = 'TEXT';
            $longTermMemory->save();
        }
    }

}
