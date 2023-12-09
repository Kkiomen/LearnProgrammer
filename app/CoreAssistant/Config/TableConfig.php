<?php

namespace App\CoreAssistant\Config;

use App\CoreAssistant\Config\TableToPrompts\TableConfigHelper\TableConfigFieldType;

class TableConfig
{
    public static function getTableConfig(): array
    {

        // CLIENTS, PRODUCTS, INVOICES, INVOICE_POSITIONS
        return [
            [
                'table_name' => 'CLIENTS',
                'table_fields' => [
                    [
                        'field_name' => 'ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'CITY',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'ZIP',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'COUNTRY',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                ],
            ],
            [
                'table_name' => 'PRODUCTS',
                'table_fields' => [
                    [
                        'field_name' => 'ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'GROUP_NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'BARCODE',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                ],
            ],
            [
                'table_name' => 'INVOICES',
                'table_fields' => [
                    [
                        'field_name' => 'ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'SYMBOL',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'ISSUE_DATE',
                        'field_type' => TableConfigFieldType::DATE,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'PERIOD',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "202001'
                    ],
                    [
                        'field_name' => 'INVOICE_TYPE_ID',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "SPK"'
                    ],
                    [
                        'field_name' => 'INVOICE_TYPE_NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "Korekta sprzedażowa"'
                    ],
                    [
                        'field_name' => 'INVOICE_FOLDER_ID',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "SU2"'
                    ],
                    [
                        'field_name' => 'INVOICE_FOLDER_NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "MM UK SOU"'
                    ],
                    [
                        'field_name' => 'DEPARTMENT_ID',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "SOUTHALL"'
                    ],
                    [
                        'field_name' => 'DEPARTMENT_NAME',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => 'example: "Southall"'
                    ],
                    [
                        'field_name' => 'CLIENT_ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'INVOICE_CURRENCY',
                        'field_type' => TableConfigFieldType::VARCHAR,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'NET_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'GROSS_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'LEFT_TO_PAY',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'PAID_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ]
                ],
            ],
            [
                'table_name' => 'INVOICE_POSITIONS',
                'table_fields' => [
                    [
                        'field_name' => 'ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'INVOICE_ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'PRODUCT_ID',
                        'field_type' => TableConfigFieldType::INTEGER,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'QUANTITY',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'NET_PRICE',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'GROSS_PRICE',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'NET_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => "sum net QUANTITY * NET_PRICE"
                    ],
                    [
                        'field_name' => 'GROSS_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => "sum gross QUANTITY * NET_PRICE"
                    ],
                    [
                        'field_name' => 'DISCOUNT_PERCENT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ],
                    [
                        'field_name' => 'DISCOUNT_AMOUNT',
                        'field_type' => TableConfigFieldType::NUMERIC,
                        'field_additional_information' => null
                    ]
                ],
            ]
        ];

        // IF YOU WANT TO ADD NEW TABLE REMEMBER ABOUT: CoreAssistant/Config/TableToPrompts/TablePrompt.php
    }
}
