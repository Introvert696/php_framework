<?php


namespace core\base\settings;
use core\base\settings;

class ShopSettings{
    
    static private $_instance;
    private $baseSettings;
    
    private $templateArr = [
        'text' => ['price','short'],
        'textarea' => ['goods_content']
        
    ];
    
    private function __construct(){
        
    }
    private function __clone(){
        
    }
    
    static public function instance(){
        if(self::$_instance instanceof self){
            return self::$_instance;
        }
        //тут мы получили типо все свойства того роута(переменной)
        //чтоб потом обьеденить их
        self::$_instance->baseSettings = Settings::instance();  
        $baseProperities = self::$_instance->baseSettings->clueProperities(get_class());
        
        return self::$_instance = new self;
    }
    static public function get($properiety){
        return self::instance()->$properiety;
    }
    
    
    
}
