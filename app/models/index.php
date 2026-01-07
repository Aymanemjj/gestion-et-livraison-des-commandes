<?php

use App\models\BaseModelUser;
use App\models\BaseModelCommand;
use App\models\BaseModelOffer;

require 'Database.php';
require 'BaseModelUser.php';
require 'BaseModelCommand.php';
require 'BaseModelOffer.php';
require 'User.php';
require 'Command.php';
require 'Offer.php';


$user = new BaseModelUser();
$user->save('glip', 'bip', 'glip@email.com', '1414', '1');
$find = $user->find('glip@email.com');

var_dump($find);


$command = new BaseModelcommand();
$command->save('grocerys', 'tomayto tomahto', '2');
$findcommand = $command->find('grocerys');

var_dump($findcommand);

$offer = new  BaseModelOffer();
$offer->save('144','express', '1','1','2');
$findoffer=$offer->find('150');
var_dump($findoffer);
