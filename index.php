<?php

// FRONT CONTROLLER

// Загальні настройки
ini_set('display_errors',1); // відображення помилок
error_reporting(E_ALL);

session_start();  //створюємо сесію для користувача

// Підключення файлів оголошення констант
define('ROOT', dirname(__FILE__));    
require_once(ROOT.'/components/Autoload.php'); //підключення автозавантаження класів
define('MyDomain', '/site_1/index.php'); // ! константа, (залежить від локального сервера)


// Виклик Router
$router = new Router();
$router->run();