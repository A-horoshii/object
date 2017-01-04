<?php
require_once 'ShopProduct.class.php';

function classData(ReflectionClass $class){
    $details = "";
    $name = $class->getName();
    if($class->isUserDefined()){
        $details .="$name -- класс определен пользователем<br>";
    }
    if($class->isInternal()){
        $details .="$name --- встроенный класс<br>";
    }
    if($class->isInterface()){
        $details .= "$name -- это интерфейс<br>";
    }
    if($class->isAbstract()){
        $details .= "$name -- это абстрактный класс <br>";
    }
    if($class->isFinal()){
        $details .= "$name -- это завершенный класс <br>";
    }
    if($class->isInstantiable()){
        $details .= "$name -можно создать экземпл€р класса<br>";
    }else{
        $details .="$name -- нельз€ создать экземпл€р класса";
    }
    return $details;
}

function methodData(ReflectionMethod $method){
    $details = '';
    $name = $method->getName();

    if($method->isUserDefined()){
        $details.= "$name -- user method.";
    }
    if($method->isInternal()){
        $details.= "$name - inside method.";
    }
    if($method->isAbstract()){
        $details.= "$name - јбстрактный.";
    }
    if($method->isPublic()){
        $details.= "$name - общедостпупный";
    }
    if($method->isProtected()){
        $details.= "$name - защищЄнные";
    }
    if($method->isPrivate()){
        $details.= "$name - закрытый";
    }
    if($method->isStatic()){
        $details.= "$name - статичный";
    }
    if($method->isConstructor()){
        $details.= "$name - метод конструктора ";
    }
    if($method->returnsReference()){
        $details.= "$name - ссылка а не значение";
    }
    return $details;
}

function argData(ReflectionParameter $arg){
    $details = "";
    $declaringClass = $arg->getDeclaringClass();
    $name = $arg->getName();
    $class = $arg->getClass();
    $position = $arg->getPosition();
    $details .= "\$$name находитс€ в позиции $position\n";
    if(!empty($class)) {
        $class_name = $class->getName();
        $details .= "\$$name должен быть объектом типа  $class_name\n";
    }
    if($arg->isPassedByReference()){
        $details .= "\$$name передан по ссылке\n";
    }
    if($arg->isDefaultValueAvailable()){
        $def = $arg->getDefaultValue();
        $details .= "\$$name по умолчаню равно: $def\n";
    }
    return $details;
}
$prod_class= new ReflectionClass('CDProduct');
$methods= $prod_class->getMethods();
foreach($methods as $method){
    print methodData($method);
    print "---<br>";
}
//print classData($prod_class);
//$method = $prod_class->getMethod("__construct");
//$params = $method->getParameters();
//
//foreach($params as $param){
//    print argData($param);
//}