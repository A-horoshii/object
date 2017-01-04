<?php
class Person {
    public $name;

    function  __construct($name){
        $this->name = $name;
    }
}

interface Module{
    function execute();
}

class FtpModule implements Module{
    function  setHost($host){
        print "FtpModule::setHost(): $host)\n";
    }

    function  setUser($user){
        print "FtpModule::setUser(): $user)\n";
    }

    function  execute(){
        // work out
    }
}

class PersonModule implements  Module {
    function setPerson(Person $person) {
        print "PersonModule::setPerson(): {$person->name}\n";
    }

    function execute(){
        // work out
    }
}

class ModuleRunner {
    private $configData = array(
        "PersonModule" => array('person' => 'bob'),
        "FtpModule" => array('host' => 'exed.com',
                             'user' => 'anon')
                        );
    private $modules = array();

    function init(){
        $interface = new ReflectionClass('Module');
        foreach($this->configData as $moduleName => $params){
            $moduleClass = new ReflectionClass($moduleName);
            if(!$moduleClass->isSubclassOf($interface)){
                throw new Exception("Неизвестный тип модуля $moduleName");
            }
            $module = $moduleClass->newInstance();
            foreach($moduleClass->getMethods() as $method){
                $this->handleMethod($module, $method, $params);
            }
            array_push($this->modules, $module);
        }
    }
    function handleMethod(Module $module, ReflectionMethod $method, $params){
        $name = $method->getName();
        $args = $method->getParameters();

        if(count($args) !=1 || substr($name,0,3) != "set"){
            return false;
        }

        $property = strtolower(substr($name, 3));
        if (!isset($params[$property])){
            return false;
        }

        $arg_class = $args[0]->getClass();
        if(empty($arg_class)){
            $method->invoke($module,$params[$property]);
        }else{
            $method->invoke($module, $arg_class->newInstance($params[$property]));
        }
    }
}

$test = new ModuleRunner();
$test->init();