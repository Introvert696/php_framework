<?php
//Шаблон проектирования SingleTon
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\base\controllers;



class RouteController {
    static private $_instance;
    
    public $hair = "Русые";
    private function __construct(){
        
    }
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
}
