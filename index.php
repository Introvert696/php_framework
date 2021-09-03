<?php

//Определим константу безопасности
define('VG_ACCESS',true);

//Отправим пользователю заголовки с типом контента
header("Content-Type:text/html;charset=utf-8");

//Стартуем сессию, закрываеться при закрытии браузера
session_start();



//Подключение файлов
//Базовые настройки сайта
require_once 'config.php';
//Настройки: пути к шаблонам
require_once 'core/base/settings/internal_settings.php';
//подлючение функции для нормального отображения массива
require_once 'libraries/function.php';
//Импортирование пространства имен
use core\base\exceptions\RouteException;
use core\base\controllers\RouteController;


try{
    //RouteController::getInstance()->route(); 
    RouteController::getInstance();
    
}
catch(RouteException $e){
    exit($e->getMessage());
}
