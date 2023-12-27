<?php

namespace App\CoreAssistant\Helper;

class SqlHelper
{
    public static function extractSqlQuery($inputString): ?string {
        $startMarker = "```sql";
        $endMarker = "```";

        // Znalezienie pozycji początkowego i końcowego znacznika
        $startPos = strpos($inputString, $startMarker);
        $endPos = strpos($inputString, $endMarker, $startPos + strlen($startMarker));

        // Sprawdzenie czy znaczniki zostały znalezione
        if ($startPos === false || $endPos === false) {
            return null;
        }

        // Obliczenie długości zapytania SQL
        $startPos += strlen($startMarker);
        $length = $endPos - $startPos;

        // Wydobycie i zwrócenie zapytania SQL
        return trim(substr($inputString, $startPos, $length));


//        $startMarker = "```sql";
//        $endMarker = "```";
//
//        // Znalezienie pozycji początkowego i końcowego znacznika
//        $startPos = strpos($inputString, $startMarker);
//        $endPos = strpos($inputString, $endMarker, $startPos);
//
//        // Sprawdzenie czy znaczniki zostały znalezione
//        if ($startPos === false || $endPos === false) {
//            return null;
//        }
//
//        // Obliczenie długości zapytania SQL
//        $startPos += strlen($startMarker);
//        $length = $endPos - $startPos;
//
//        // Wydobycie i zwrócenie zapytania SQL
//        return trim(substr($inputString, $startPos, $length));
    }
}
