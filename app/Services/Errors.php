<?php

namespace CodeProject\Services;

class Errors {

   public static function basic($msg) {
        return [
            'error' => true,
            'message' => $msg,
        ];
    }

    public static function invalidId($id) {
        return [
            'error' => true,
            'message' => "Falha. Id ".$id." invalido!",
        ];
    }
}
