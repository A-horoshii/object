<?php
require_once 'ShopProduct.class.php';

function classData(ReflectionClass $class){
    $details = "";
    $name = $class->getName();
    if($class->isUserDefined()){
        $details .="$name -- ����� ��������� �������������<br>";
    }
    if($class->isInternal()){
        $details .="$name --- ���������� �����<br>";
    }
    if($class->isInterface()){
        $details .= "$name -- ��� ���������<br>";
    }
    if($class->isAbstract()){
        $details .= "$name -- ��� ����������� ����� <br>";
    }
    if($class->isFinal()){
        $details .= "$name -- ��� ����������� ����� <br>";
    }
    if($class->isInstantiable()){
        $details .= "$name -����� ������� ��������� ������<br>";
    }else{
        $details .="$name -- ������ ������� ��������� ������";
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
        $details.= "$name - �����������.";
    }
    if($method->isPublic()){
        $details.= "$name - ��������������";
    }
    if($method->isProtected()){
        $details.= "$name - ����������";
    }
    if($method->isPrivate()){
        $details.= "$name - ��������";
    }
    if($method->isStatic()){
        $details.= "$name - ���������";
    }
    if($method->isConstructor()){
        $details.= "$name - ����� ������������ ";
    }
    if($method->returnsReference()){
        $details.= "$name - ������ � �� ��������";
    }
    return $details;
}

function argData(ReflectionParameter $arg){
    $details = "";
    $declaringClass = $arg->getDeclaringClass();
    $name = $arg->getName();
    $class = $arg->getClass();
    $position = $arg->getPosition();
    $details .= "\$$name ��������� � ������� $position\n";
    if(!empty($class)) {
        $class_name = $class->getName();
        $details .= "\$$name ������ ���� �������� ����  $class_name\n";
    }
    if($arg->isPassedByReference()){
        $details .= "\$$name ������� �� ������\n";
    }
    if($arg->isDefaultValueAvailable()){
        $def = $arg->getDefaultValue();
        $details .= "\$$name �� �������� �����: $def\n";
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