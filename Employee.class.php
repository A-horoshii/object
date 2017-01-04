<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 16.06.2016
 * Time: 16:36
 */

abstract class Employee {
    protected $name;
    private static $types = array('Minion','CluedUp','WellConnected');

    static function recruit($name){
        $num = rand(1, count(self::$types))-1;
        $class = self::$types[$num];
        return new $class($name);
    }

    function __construct($name){
        $this->name = $name;
    }

    abstract  function fire();
}

class Minion extends Employee {

    function fire(){
        print "$this->name: ����� �� ������";
    }
}
class WellConnected extends Employee {

    function fire(){
        print "$this->name: �������";
    }
}
class CluedUp extends Employee{
    function fire(){
            print "$this->name: ������ ��������";
        }
}

class NastyBoss{
    private $employees = [];

    function addEmployee(Employee $employee){
        $this->employees[] = $employee;
    }

    function projectFails(){
        if (count($this->employees)>0){
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee(Employee::recruit('����'));
$boss->addEmployee(Employee::recruit('����'));
$boss->addEmployee(Employee::recruit('����'));
//$boss->projectFails();
//$boss->projectFails();
var_dump($boss);