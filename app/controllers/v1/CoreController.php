<?php
namespace Controllers\V1;

class CoreController {

    /**
     * Converte um objeto que implementa a interface JsonSerializable para personalizar 
     * como o objeto será estruturado no formato Json.
     */
    protected static function convertObjToArray($obj) {
        $objAsString = json_encode($obj); // obj para string
        $objAsArray = json_decode($objAsString, true); // string para array associativo

        return $objAsArray;
    }
}