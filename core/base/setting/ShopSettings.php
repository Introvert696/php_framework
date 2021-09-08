<?php


namespace core\base\setting;
use core\base\setting\Settings;

class ShopSettings{
    
    static private $_instance;
    private $baseSettings;
    
    private $routes = [
       
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
            'dir' => 'controller',
            'routes' => [
                
            ]
        ],
        
    ];
    
    private $lalala ='lalala';



    private function __construct(){
        
    }
    private function __clone(){
        
    }
    
    static public function instance(){
        if(self::$_instance instanceof self){
            return self::$_instance;
        }
            
        self::$_instance = new self;
        //тут мы получили типо все свойства того роута(переменной)
        //чтоб потом обьеденить их
        self::$_instance->baseSettings = Settings::instance();  
        $baseProperties = self::$_instance->baseSettings->clueProperities(get_class());
        self::$_instance->setProperty($baseProperties);
        print_arr($baseProperties);
        
        return self::$_instance;
    }
    static public function get($property){
        return self::instance()->$property;
    }
    
    protected function setProperty($property){
        if($property){
            foreach($property as $name => $property){
                $this->$name = $property;
            }
        }
    }
    
    
    
    
}
