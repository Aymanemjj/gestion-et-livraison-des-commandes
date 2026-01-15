<?php

require '../vendor/autoload.php';

use App\models\Auth;
use App\models\BaseModelUser;
use App\models\BaseModelCommand;
use App\models\BaseModelOffer;
use App\models\Command;
use App\models\User;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['submit'])) {
        return;
    }
    switch ($_POST['submit']) {
        case 'logout':

            $auth = new Auth();
            $auth->logOut();
            break;

        case 'command':
            $command = new Command();
            $command->afterMath();
            break;
    }
}
