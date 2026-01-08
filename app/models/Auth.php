<?php

namespace App\models;

class Auth
{





    public function signUp(object $user): bool
    {
        if (!$this->isValidFirstname($user)) {
            return false;
        }
        if (!$this->isValidLastname($user)) {
            return false;
        }
        if (!$this->isValidEmail($user)) {
            return false;
        }
        $user->save();
        return true;
    }




    public function signIn(object $user): bool
    {

        if (!$this->isValidEmail($user)) {
            return false;
        }
        if (!$this->isValidPassword($user)) {
            return false;
        }
        return true;
    }

    public function logOut()
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);

        header("Location: ../index.php");
        exit;
    }


    private function isValidFirstname(object $user): bool
    {
        $pattern = "/^(.*?)\s([\wáâàãçéêíóôõúüÁÂÀÃÇÉÊÍÓÔÕÚÜ]+\-?'?\w*\.?)$/u";

        return preg_match($pattern, $user->getFirstname()) === 1;
    }

    private function isValidLastname(object $user): bool
    {
        $pattern = "/^(.*?)\s([\wáâàãçéêíóôõúüÁÂÀÃÇÉÊÍÓÔÕÚÜ]+\-?'?\w*\.?)$/u";

        return preg_match($pattern, $user->getLastname()) === 1;
    }

    private function isValidEmail(object $user): bool
    {
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $object = $user->find();
        if (is_null($object)) {
            return false;
        } else {
            if (!$object->getEmail() === $user->getEmail()) {
                return false;
            } else {
                return true;
            }
        }
    }

    private function isValidPassword($user): bool
    {
        $object = $user->find();
        return password_verify($object->getPassword(), $user->getPassword());
    }
}
