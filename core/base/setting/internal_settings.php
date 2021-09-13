<?php

defined("VG_ACCESS") or die("Access denide");
use core\base\exceptions;


//шаблоны пользовательской части
const TEMPLATE = 'templates/default';
//Путь к админ панели сайта
const ADMIN_TEMPLATE = 'core/admin/view';
//версия куков для сброса все юзеров типо того
const COOKIE_VERSION = '1.0.0';
//Ключ шифрования для куков
const CRYPT_KEY = '';
//Время работы куки, время бездействия
const COOKIE_TIME = 60;
//Время блокировки юзера, который пытался войти в сайт
const BLOCK_TIME = 3;
//

//построничная навигация
//количество отображения товаров на странице
const QTY = 8;
const QTY_LINKS = 4;

//путь для ксс и дж для работы админ панели
const ADMIN_CSS_JS = [
    'style' => [],
    'scripts' => []
];
//путь для ксс и дж для работы юзерского интрефейса
const USER_CSS_JS = [
    'style' => [],
    'scripts' => []
];




//автозагрузка классов
function autoloadMainClasses($class_name){
    $class_name = str_replace("\\", "/", $class_name);
    
    if(!@include_once $class_name.'.php'){
        //выбросить исключение
        throw new RouteException('Не верное имя файла для подключения'.$class_name);
    }
        
}
spl_autoload_register('autoloadMainClasses');
