<?php

namespace App\models;

use ReturnTypeWillChange;

class Auth
{





    public function validSignUp(object $user): bool
    {


        if (!$this->isValidFirstname($user)) {
            return false;
        }
        if (!$this->isValidLastname($user)) {
            return false;
        }
        if (!$this->isValidEmailSignUp($user)) {
            return false;
        }
        /*         $user->save();
 */
        return true;
    }


    public function afterMath()
    {
        switch ($_POST['submit']) {
            case 'signup':
                $user = new User();
                $user->setters();



                if (!$this->validSignUp($user)) {
                    $user->save();
                    $this->startSession($user);
                    switch ($user->getRole()) {
                        case 2:
                            header("Location: views/dashboard-client.php");
                            exit;
                            break;
                        case 3:

                            header("Location: views/dashboard-livreur.php");
                            exit;
                            break;
                    }
                }
                break;
            case 'signin':
                $user = new User();

                $user->setters();

                if ($this->signin($user)) {

                    $object = $user->find();
                    $this->startSession($object);

                    switch ($object->getRole()) {
                        case 2:
                            header("Location: views/dashboard-client.php");
                            break;

                        case 3:
                            header("Location: views/dashboard-livreur.php");
                            break;
                    }
                    exit;
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }

                break;
        }
    }




    public function signIn(object $user): bool
    {

        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $object = $user->find();
        if (is_null($object)) {
            return false;
        }
        if (!password_verify($user->getPassword(), $object->getPassword())) {
            return false;
        }
        return true;
    }




    public function startSession($user)
    {
        session_start();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['email']  = $user->getEmail();
        $_SESSION['role'] = $user->getRole();
        $_SESSION['logged_in'] = true;
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


        return true;
    }

    private function isValidLastname(object $user): bool
    {
        $pattern = "/^(.*?)\s([\wáâàãçéêíóôõúüÁÂÀÃÇÉÊÍÓÔÕÚÜ]+\-?'?\w*\.?)$/u";

        return preg_match($pattern, $user->getLastname()) === 1;


        return true;
    }

    private function isValidEmailSignUp(object $user): bool
    {
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $object = $user->find();
        if (is_null($object)) {
            return true;
        } else {
            return false;
        }
    }
}
