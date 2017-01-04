<?php
abstract class Unit {


    function getComposite(){
        return null;
    }
    abstract function bombardStrength();

    function textDump($num = 0){
        $ret = "";
        $pad = 4*$num;
        $ret .= sprintf("%{$pad}s","");
        $ret .= get_class($this).":";
        $ret .= "Strength equals: ". $this->bombardStrength()."\n";
        return $ret;
    }

    function accept(ArmyVisitor $visitor){
        $method = "visit".get_class($this);
        $visitor->$method($this);
    }

    protected  function setDepth($depth){
        $this->depth = $depth;
    }
    function getDepth(){
        return $this->depth;
    }
}
abstract class  ArmyVisitor{
    abstract function visit(Unit $node);

    function visitArcher(Archer $node){
        $this->visit($node);
    }

    function visitLaserCannonUnit(LaserCannonUnit $node){
        $this->visit($node);
    }
    function visitArmy(Army $node){
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor{
    private $text = "";

    function visit(Unit $node){
        $ret = "";
        $pad = 4*$node->getDepth();
        $ret .= sprintf("%{$pad}s","");
        $ret .= get_class($node).":";
        $ret .= "Strength equals: ". $node->bombardStrength()."\n";
        $this->text.=$ret;
    }

    function getText(){
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor{
    private $due = 0;
    private $report = "";

    function visit(Unit $node){
        $this->levy($node, 1);
    }

    function visitArcher(Archer $node){
        $this->levy($node, 2);
    }

    function visitLaserCannonUnit(LaserCannonUnit $node){
        $this->levy($node, 3);
    }

    private function levy(Unit $unit, $amount){
        $this->report .="Tax for ".get_class($unit);
        $this->report .= ": $amount <br>";
        $this->due += $amount;
    }

    function getReport(){
        return $this->report;
    }

    function getTax(){
        return $this->due;
    }


}

abstract class CompositeUnit extends Unit{
    private $units = array();

    function getComposite(){
        return $this;
    }

    protected function units(){
        return $this->units;
    }

    function addUnit(Unit $unit){
        foreach($this->units as $thisunit){
            if($unit === $thisunit){
                return;
            }
        }
        $this->setDepth($this->depth+1);
        $this->units[] = $unit;
}
    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units, array($unit),
            function($a, $b){return ($a === $b)?0:1;});
    }

    function textDump($num = 0){
        $ret = parent::textDump($num);
        foreach ($this->units as $unit){
            $ret .= $unit->textDump($num+1);
        }
        return $ret;
    }



}
class UnitException extends Exception{}


class Archer extends Unit{

    function bombardStrength(){
        return 4;
    }
}

class LaserCannonUnit extends Unit{


    function bombardStrength(){
        return 44;
    }
}

class Army extends Unit{
    private  $units = array();

    function accept(ArmyVisitor $visitor){
        $method = "visit".get_class($this);
        $visitor->$method($this);

        foreach($this->units as $thisunit){
            $thisunit->accept($visitor);
        }
    }

    function addUnit(Unit $unit){
        foreach($this->units as $thisunit){
            if($unit === $thisunit){
                return;
            }
        }
        $this->setDepth($this->depth+1);
        $this->units[] = $unit;
    }
    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units, array($unit),
            function($a, $b){return ($a === $b)?0:1;});
    }

//    function getUnit(Unit $unit){
//        return $this->units[array_search($unit,$this->units)];
//    }


    function bombardStrength(){
        $ret = 0;
        foreach($this->units as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}


class UnitScript{
    static function joinExisting(Unit $newUnit, Unit $occupyingUnit){

        if (!is_null($comp = $occupyingUnit->getComposite())){
            $comp->addUnit($newUnit);
        }else{
            $comp = new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
    }
}

$arm1 = new Army();
$arm1->addUnit(new Archer());
$arm1->addUnit(new LaserCannonUnit());
//$arm1->removeUnit($arch1);

$taxdump = new TaxCollectionVisitor();
$arm1->accept($taxdump);
print $taxdump->getReport()."<br>";
print "in total:";
print $taxdump->getTax();
//$arm2 = new Army();
//
//
//$arm2->addUnit(new LaserCannonUnit());
//
//$arm2->addUnit(new LaserCannonUnit());
//
//$arm2->addUnit($arm1);
//
//
//print "Defending power all Units = {$arm2->bombardStrength()}";
