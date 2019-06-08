<?php
define('APP_ROOT', __DIR__);

session_start();
// todo
$_SESSION['memberid'] = 1;

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
//require_once dirname(APP_ROOT).'/vendor/autoload.php';
//date_default_timezone_set('UTC+03:00');
//echo "<pre>";print_r($_SERVER);
spl_autoload_register(function ($name) {
    $name = preg_replace('/^RestApi\\\\/', '', $name);
    $name = str_replace('\\', '/', $name);
    $file = __DIR__ . '/Classes/' .$name.'.php';
    if(file_exists($file)) {
        require_once $file;
        return;
    }
});



