<?php

namespace App\Enum;

enum OpenAiModel: string
{
    case DAVINCI = 'text-davinci-003';
    case CHAT_GPT_3 = 'gpt-3.5-turbo';

    case TEXT_EMBEDDING_ADA  = 'text-embedding-ada-002';

    public static function toArray(){
        return [
            self::DAVINCI->value,
            self::CHAT_GPT_3->value,
            self::TEXT_EMBEDDING_ADA->value,
        ];
    }

    /**
    0 => babbage
    1 => davinci
    2 => text-davinci-edit-001
    3 => babbage-code-search-code
    4 => text-similarity-babbage-001
    5 => code-davinci-edit-001
    6 => text-davinci-001
    7 => ada
    8 => babbage-code-search-text
    9 => babbage-similarity
    10 => code-search-babbage-text-001
    11 => text-curie-001
    12 => code-search-babbage-code-001
    13 => text-ada-001
    14 => text-embedding-ada-002
    15 => text-similarity-ada-001
    16 => curie-instruct-beta
    17 => ada-code-search-code
    18 => ada-similarity
    19 => code-search-ada-text-001
    20 => text-search-ada-query-001
    21 => davinci-search-document
    22 => ada-code-search-text
    23 => text-search-ada-doc-001
    24 => davinci-instruct-beta
    25 => gpt-3.5-turbo
    26 => text-similarity-curie-001
    27 => code-search-ada-code-001
    28 => ada-search-query
    29 => text-search-davinci-query-001
    30 => curie-search-query
    31 => gpt-3.5-turbo-0301
    32 => davinci-search-query
    33 => babbage-search-document
    34 => ada-search-document
    35 => text-search-curie-query-001
    36 => whisper-1
    37 => text-search-babbage-doc-001
    38 => curie-search-document
    39 => text-davinci-003
    40 => text-search-curie-doc-001
    41 => babbage-search-query
    42 => text-babbage-001
    43 => text-search-davinci-doc-001
    44 => text-search-babbage-query-001
    45 => curie-similarity
    46 => curie
    47 => text-similarity-davinci-001
    48 => text-davinci-002
    49 => davinci-similarity
    50 => cushman:2020-05-03
    51 => ada:2020-05-03
    52 => babbage:2020-05-03
    53 => curie:2020-05-03
    54 => davinci:2020-05-03
    55 => if-davinci-v2
    56 => if-curie-v2
    57 => if-davinci:3.0.0
    58 => davinci-if:3.0.0
    59 => davinci-instruct-beta:2.0.0
    60 => text-ada:001
    61 => text-davinci:001
    62 => text-curie:001
    63 => text-babbage:001
     */
}

