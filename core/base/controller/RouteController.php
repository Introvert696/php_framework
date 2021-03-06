<?php
//Шаблон проектирования SingleTon
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\base\controller;
use core\base\exceptions;
use core\base\setting\Settings;
use core\base\setting\ShopSettings;


//точка входа в контроллеры
class RouteController {
    static private $_instance;
    //сюда примим наши роуты с настроек
    protected $routes;   
    //здесь будет хранится контроллер
    protected $controller;   
    //метод выбора  из бд, т.е. модель
    protected $inputMethod;    
    //имя метода отвечающая за подключение вида
    protected $outputMethod;
    protected $parameters;





    private function __clone() {
        
    }   


    static public function getInstance(){
        //хранится ли в свойстве instance обьект нашего класса
//           Если хранится, то мы возращаем его
//           Если нет, то мы создаем и возращаем свой же обьект
        if(self::$_instance instanceof self){
            return self::$_instance;
        }
        return self::$_instance = new self;
    }
    
    private function __construct(){
        
        
        $address_str = $_SERVER['REQUEST_URI'];
        
        
        if(strrpos($address_str,'/') === strlen($address_str)-1  && strrpos($address_str , '/') !== 0){
            //$this->redirect(rtrim($address_str,'/'),301);
        }
        
        $path = substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'],'index.php'));
        //print_r($path);
        
        if($path === PATH){
            //Получаем свойство роут класса Сеттинг
            //Settings::instance();
            $this->routes = Settings::get('routes');
            
            if(!$this->routes){
                throw new RouteException('Сайт находится на техническом обслуживании');         
            }
            //print_arr($address_str);
            
            if(strpos($address_str, $this->routes['admin']['alias']) === strlen(PATH)){
                //проверка на вход в админку
                /* Админка*/
                
                $url = explode('/',substr($address_str,strlen(PATH.$this->routes['admin']['alias']) + 1));
                //print_arr($url);
                if($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])){
                    
                    //print_r(is_dir($_SERVER['DOCUMENT_ROOT']) . PATH . $this->routes['plugins']['path'] . $url[0]);
                    //работа с плагинами
                    //$plugin = array_shift($url);
                    //заменил т.к. не работало
                    $plugin = $url[0];
                    $pluginSettings = $this->routes['settings']['path'].ucfirst($plugin.'Settings');
                    
                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginSettings . '.php')){
                        $pluginSettings = str_replace('/', '\\', $pluginSettings);
                        $this->routes= $pluginSettings::get('routes');
                    }
                    $dir = $this->routes['plugins']['dir'] ? '/'.$this->routes['plugins']['dir']. '/' : '/' ;
                    $dir = str_replace('//','/',$dir); 
                    
                    $this->controller = $this->routes['plugins']['path'].$plugin.$dir;
                    $hrUrl = $this->routes['plugins']['hrUrl'];
                    
                    $route = 'plugins';
                //print_arr($this);
                    
                    
                    
                    
                } else {
                    $this->controller = $this->routes['admin']['path'];
                    
                    $hrUrl = $this->routes['admin']['hrUrl'];
                    
                    $route = 'admin';
                }
                
                
                
            }
            else{
                //если нету алиаса 
                //пользовательская часть
                
                //получаем юрл без 
                $url = explode('/',substr($address_str,strlen(PATH)));
                
                //делать чпу читабельным или нет
                $hrUrl = $this->routes['user']['hrUrl'];
                
                //коетроллеры юзера
                $this->controller = $this->routes['user']['path'];
                
                $route = 'user';
                
            }
            
            $this->createRoute($route,$url);
            //print_r(isset($url[1]));
            //добавил isset*()
            if(isset($url[1])){
                //если есть параметры
                $count = count($url);               
                $key = '';
                
                
                if(!$hrUrl){
                    $i = 1;
                }else{
                    $this->parameters['alias']=$url[1];
                    $i = 2;
                }
                //print_arr($url);
                for(;$i < $count;$i++){
                    if(!$key){
                        //echo 'Создание параметра '.$url[$i];
                        $key = $url[$i];
                        $this->parameters[$key] = '';
                    }else{
                        $this->parameters[$key] = $url[$i];
                        $key = '';
                    }
                    //print_arr($this->parameters);
                }
                
                
            }
            
               print_arr($this);
            
            
            //exit();
            
            
     
        }else{
            try {
                throw \Exception('Некоректная директория сайта');
            } catch (\Exception $exc) {
                exit($exc->getMessage());
            }
                }
                
                
                
         
        //получение всех свойств
        //$s = Settings::instance();
        //$s1 = ShopSettings::instance();
        
        
        
        //print_arr($s);
        //print_arr($s1);    
        
    }
    
    private function createRoute($var,$arr){
        
        $route = [];
        
        if(!empty($arr[0])){
            // добавил isset()
            if(isset($this->routes[$var]['routes'][$arr[0]])){
                $route = explode('/',$this->routes[$var]['routes'][$arr[0]]);
                
                $this->controller .= ucfirst($route[0].'Controller');
                //print_arr($this->controller);
                
                
            }else{
                $this->controller .= ucfirst($arr[0].'Controller');
            }
        }
        else{
            $this->controller .= $this->routes['default']['controller'];
        }
        
        //ВНИМАНИЕ ИЗМЕНИЛ ПРОСТО $route[1] на isset($route[1])

        $this->inputMethod = isset($route[1]) ? $route[1] : $this->routes['default']['inputMethod'];
        $this->outputMethod=  isset($route[2]) ? $route[2] : $this->routes['default']['outputMethod'];
        
        //print_arr($this->controller);
        return;
    }
}
