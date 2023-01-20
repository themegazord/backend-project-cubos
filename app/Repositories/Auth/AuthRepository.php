<?php

namespace App\Repositories\Auth;
use Laravel\Sanctum\PersonalAccessToken;

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

    public static function getTheUserWhoOwnsTheToken($token) {
        return PersonalAccessToken::findToken($token)->tokenable()->get()->toArray();
    }

    public static function createResponseToRegister($token) {
        $user = AuthRepository::getTheUserWhoOwnsTheToken($token);
        return [
            'token' => $token,
            'id' => AuthRepository::getIdUser($user),
            'name' => AuthRepository::getUserName($user),
            'aka' => AuthRepository::generateAkaNameUser($user),
        ];
    }

}

?>
