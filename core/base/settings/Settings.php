<?php
//файл настроек фреймворка

namespace core\base\settings;


class Settings 
{
    static private $_instance;
    
    
    
    //маршруты и настройки
    private $routes = [
        'admin'=>[
            'name' => 'admin',
            'path' => 'core/admin/controllers/',
            'hrUrl' => false,
            
        ],
        'settings' =>[
            'path' => 'core/base/settings/',
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
        ],
        'user'=>[
            'path'=>'core/user/controllers/',
            'hrUrl' => true,
            'routes' => [
                //Роуты для юзера
            ]
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
            
        ]
    ];
    
    private $templateArr = [
        'text' => ['text','phone','adress'],
        'textarea' => ['content','keyword']
        
    ];
    
    private function __construct(){
        
    }
    private function __clone(){
        
    }
    static public function instance(){
        if(self::$_instance instanceof self){
            return self::$_instance;
        }
        return self::$_instance = new self;
    }
    static public function get($properiety){
        return self::instance()->$properiety;
    }
    public function clueProperities($class){
        $baseProperties = [];
        
        foreach ($this as $name => $item){
            $property = $class::get($name);
            $baseProperties[$name] = $property;
         }
         print_r($baseProperties);
         exit();
    }   
}
