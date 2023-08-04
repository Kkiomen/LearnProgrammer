<?php

namespace App\Snippets;

use App\Abstract\Snippet;
use App\Api\OpenAiApi;
use App\Helpers\RequestHelper;

class AutomaticTestOpenaiSnippet extends Snippet
{

    protected bool $fullResponse = true;
    protected bool $manyResponse = true;
    public function getName(): string
    {
        return 'automatic-test-openapi';
    }

    public function resultSnippet($message): string
    {
        //$message = 'Endpoint: /api/admin/units/{unit_id} %%% Method: delete ### Information OpenApi: {"tags":["Units"],"operationId":"delete_wise_product_apiadmin_units_deleteunitsbykey_deleteunits","parameters":[{"name":"x-request-uuid","in":"header","description":"UUID requestu","schema":{"type":"string"},"example":"49c9aa13-c5c3-474b-a874-755f9d553779"},{"name":"unit_id","in":"path","required":true,"schema":{"type":"string","pattern":"([a-zA-Z0-9-_])+"}}],"responses":{"200":{"description":"Zwrotka w przypadku znalezionych i poprawienie usuniętych obiektów","content":{"application/json":{"schema":{"$ref":"#/components/schemas/CommonDeleteResponseAdminApiDto"}}}},"400":{"description":"Niepoprawne dane wejściowe","content":{"application/json":{"schema":{"$ref":"#/components/schemas/InvalidInputDataResponseDto"}}}},"401":{"description":"Błędny token autoryzacyjny","content":{"application/json":{"schema":{"$ref":"#/components/schemas/UnauthorizedResponseDto"}}}}}}';
        $system = 'Return the answer in JSON and nothing else. Based on the user-provided information that comes from the OpenApi json, return a list in JSON of the most important test cases for the provided endpoint. Take into account strange situations , which can mess up the system
        Return only json and nothing else.

        ###
        Return the answer in JSON and nothing else (example format}:
        [
        {
             description:  (in the form of one sentence)
        },
        {
             description:  (in the form of one sentence)
        }, ...
        ]

        ###
        Return a minimum of 8 tests but it would be nice if there were more as JSON
        Return only json and nothing else. ';

        /**
         * @var OpenAiApi $openApi
         */
        $openApi = app(OpenAiApi::class);
        $completion = $openApi->completionChat($message, $system);

//        $completion = '[ { "description": "Send a DELETE request to the endpoint /api/admin/units/{unit_id} with valid x-request-uuid header and unit_id path parameter to delete the specified unit" }, { "description": "Send a DELETE request to the endpoint /api/admin/units/{unit_id} with an invalid x-request-uuid header and valid unit_id path parameter and verify that a 401 UnauthorizedResponseDto response is returned" }, { "description": "Send a DELETE request to the endpoint /api/admin/units/{unit_id} with a valid x-request-uuid header and an invalid unit_id path parameter and verify that a 400 InvalidInputDataResponseDto response is returned" }, { "description": "Send a DELETE request to the endpoint /api/admin/units/{unit_id} with a non-existent unit_id path parameter and verify that a 200 CommonDeleteResponseAdminApiDto response is returned" } ]';
        try{
            $this->data = [
                'many' => json_decode($completion, true),
                'snippet' => 'generate-unit-test',
                'endpoint' => $message
            ];
        }catch (\Exception $exception){
            return 'Wystąpił błąd.';
        }


       // $json = file_get_contents($message);
        //$f = json_decode($json);

        return 'Zaraz rozpocznie się generowanie testów...';
    }

    public function canDisplaySnippet(): bool
    {
        return true;
    }
}
//Test case: Send a PATCH request to the /api/admin/categories endpoint with a valid x-request-uuid header and a PutCategoriesDto request body containing a duplicate category and ensure that a 400 InvalidInputDataResponseDto is returned
//Test case: Send a PATCH request to the /api/admin/categories endpoint with a valid x-request-uuid header and a PutCategoriesDto request body containing a category with an invalid name and ensure that a 400 InvalidInputDataResponseDto is returned
