<?php 
class UpCloo_Registry
{
    private static $_instance;
    
    private $_registry;
    
    private function __construct(){}
    
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
            self::$_instance->_registry = array();
        }
        
        return self::$_instance;
    }
    
    public function set($key, $value)
    {
        $this->_registry[$key] = $value;
    }
    
    public function get($key)
    {
        return @$this->_registry[$key];
    }
}