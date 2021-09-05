<?php
//файл настроек фреймворка

namespace core\base\setting;


class Settings 
{
    static private $_instance;
    
    
    
    //маршруты и настройки
    private $routes = [
        'admin'=>[
            'alias' => 'admin',
            'path' => 'core/admin/controller/',
            'hrUrl' => false,
            
        ],
        'settings' =>[
            'path' => 'core/base/setting/',
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
        ],
        'user'=>[
            'path'=>'core/user/controller/',
            'hrUrl' => true,
            'routes' => [
                //fkbfcsдля юзера
                //controller/method(собирает дынные)/Method(отдает данных)
                'catalog' => 'site'
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
            //если проперити и наме массивы то нам нужно их склеить
            if(is_array($property) && is_array($item)){
               
              
               
                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name,$property);
                continue;

                
            }
            if(!property){
                $baseProperties[$name] = $this->name;
            }
            
         }
         return $baseProperties;
        
    }  
    public function arrayMergeRecursive(){
        $arrays = func_get_args(); //получит аргументы функции из памяти  итп\
        
        $base  = array_shift($arrays); //arrays_shift возращает первый элемент массива и удаляет его
        
        foreach($arrays as $array){
            foreach ($array as $key =>$value) {
                if(is_array($value) && is_array($base[$key])){
                    $base[$key] = $this->arrayMergeRecursive($base[$key], $value);
                }
                else {
                    if(is_int($key)){
                        if(!in_array($value,$base)){
                            array_push($base,$value);
                            continue;
                        }
                        $base[$key] = $value;
                    }
                }
            }
            return $base;
        }
        
        
        
    }
}
