<?php

/*
*
* This file connects the model files of the site.
* Session start for all
*/
session_start();

$models = array(
    'Human' => 'models/human.php',
    'Guest' => 'models/guest.php',
    'user' => 'models/user.php',
    'Usermanagment' => 'models/usermanagment.php',
    'admin' => 'models/admin.php',
    'food' => 'models/food.php',
    'member' => 'models/member.php',
    'report' => 'models/report.php',
    'reservation' => 'models/reservation.php',
    'table' => 'models/table.php',
    'Validation' => 'models/Validation.php'
);

// Dosya sadece bir kere dahil edilir.

foreach ($models as $key => $value) {
    require_once $value;
}
require_once 'Database.php';
require_once 'core/App.php';
require_once 'core/Controller.php';