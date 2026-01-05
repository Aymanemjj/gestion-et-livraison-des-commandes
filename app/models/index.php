<?php

use App\models\BaseModelUser;
require 'BaseModelUser.php';
require 'User.php';
$user=new BaseModelUser();
$user->save('glip','bip','glip@email.com','1414','1');
$find = $user->find('glip@email.com');
var_dump($find);
