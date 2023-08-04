<?php

namespace App\Modules\ProductDescription\DataSource;

class ApiProductDescriptionDataSource extends ProductDescriptionDataSource
{
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * The method returns universal data ready to be used by the prompt generator based on a request, i.e. data from the Api
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}


/*
{
  "subject": "smartfon",
  "productName": "Xiaomi XYZ",
  "category": "Elektronika",
  "attributes": [
    {
        "key": "producent",
        "value": "Xiaomi"
    },
    {
        "key": "liczba_wątków",
        "value": "8"
    },
    {
        "key": "rozmiar",
        "value": "6.5 cali"
    },
    {
        "key": "kolor",
        "value": "czarny"
    }
  ],
  "targetAudience": "man",
  "keywords": ["smartfon", "ekran", "aparat"],
  "keywordsSEO": ["najlepszy smartfon", "Xiaomi XYZ", "smartfon z dużym ekranem"],
  "imageUrl": "https://example.com/image.jpg",
  "useHtml": true,
  "styleAndTone": ["formalny", "inspirujący"],
  "limitations": ["Nieodporny na wodę"],
  "material": ["metal","szkło"],
  "usage": "codzienne korzystanie, praca, rozrywka",
  "warranty": "2 lata",
  "uniqueFeatures": ["ładowanie bezprzewodowe", "ultraszybki czytnik linii papilarnych"],
  "description": "Nowoczesny smartfon Xiaomi XYZ z dużym ekranem, wydajnym procesorem i znakomitym aparatem."
}
 */
