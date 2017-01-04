<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 25.07.2016
 * Time: 16:47
 */



class CommandContext{
    private $params = array();
    private $error = "";

    function __construct(){
        $this->params = $_REQUEST;
    }

    function addParam($key, $val){
        $this->params[$key] = $val;
    }

    function get($key){
        return $this->params[$key];
    }

    function setError($error){
        $this->error = $error;
    }
    function getError(){
        return $this->error;
    }

}

class CommandNotFoundException extends  Exception{}

class CommandFactory {
    private static $dir = "commands";

    static function getCommand($action = "default"){
        if(preg_match('/\W/',$action)){
            throw new Exception("Invalid character in command");
        }
        $class = UCFirst(strtolower($action))."Command";
        $file = self::$dir.DIRECTORY_SEPARATOR."{$class}.php";
        if(!file_exists($file)){
            throw new CommandNotFoundException("File is not foundd");
        }
        require_once($file);
        if(!class_exists($class)){
            throw new CommandNotFoundException("Class is not found");
        }
        $cmd = new $class;
        return $cmd;
    }
}

class Controller {
    private $context;

    function __construct(){
        $this->context = new CommandContext();
    }

    function getContext(){
        return $this->context;
    }

    function process(){
        $cmd = CommandFactory::getCommand($this->context->get('action'));

        if(! $cmd->execute($this->context)){
            return false;
        }else{
            return true;
        }
    }
}


$controller = new Controller();

$context = $controller->getContext();
$context->addParam("action","login");
$context->addParam("username","bob");
$context->addParam("pass","bobop");
$controller->process();

