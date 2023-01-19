<?php

namespace App\Repositories\Auth;

class AuthRepository {
    public static function generateAkaNameUser($user) {
        $nameInArray = explode(' ', $user[0]['name']);
        if(count($nameInArray) > 1) {
            $aka = strtoupper(current($nameInArray)[0]) . strtoupper(last($nameInArray)[0]);
        } else {
            $aka = strtoupper(current($nameInArray)[0]) . strtoupper(current($nameInArray)[2]);
        }
        return $aka;
    }
    public static function getIdUser($user) {
        return $user[0]['id'];
    }
    public static function getUserName($user) {
        return $user[0]['name'];
    }
}

?>
