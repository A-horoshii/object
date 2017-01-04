<?php

abstract class Lesson{

    private $duration;
    private $cost_strategy;

    function __construct($duration, CostStrategy $strategy){
        $this->duration = $duration;
        $this->cost_strategy = $strategy;
    }

    function cost(){
        return $this->cost_strategy->cost($this);
    }

    function chargeType(){
        return $this->cost_strategy->chargeType();
    }
    function getDuration(){
        return $this->duration;
    }
}

class Lecture extends Lesson{

}

class Seminar extends Lesson{

}


abstract class CostStrategy{
    abstract function cost(Lesson $lesson);
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy{
    function cost(Lesson $lesson){
        return ($lesson->getDuration()*5);
    }
    function chargeType(){
        return "Почасовая оплата";
    }
}

class FixedCostStrategy extends CostStrategy{
    function cost(Lesson $lesson){
        return(30);
    }
    function chargeType(){
        return "Фиксированная цена";
    }
}


$lessons[] = new Lecture(4, new FixedCostStrategy());
$lessons[] = new Seminar(3, new TimedCostStrategy());
foreach($lessons as $lesson){
    print "Оплата за занятие: {$lesson->cost()}.";
    print "Тип оплаты: {$lesson->chargeType()}<br>";
}