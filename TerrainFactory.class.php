<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 07.07.2016
 * Time: 11:57
 */

class Sea{
    private $navigability = 0;
    function __construct($navigability){
        $this->navigability = $navigability;
    }
    function getNavigability(){
        return $this->navigability;
    }
}
class EarthSea extends Sea{}
class MarsSea extends Sea{}

class Plains{}
class EarthPlains extends Plains{}
class MarsPlains extends Plains{}

class Forest{}
class EarthForest extends Forest{}
class MarsForest extends Forest{}

class TerrainFactory{
    private $sea;
    private $plains;
    private $forest;

    function __construct(Sea $sea, Plains $plains, Forest $forest){
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }
    function getSea(){
        return clone $this->sea;
    }
    function getPlains(){
        return clone $this->plains;
    }
    function getForest(){
        return clone $this->forest;
    }
}

//$factory = new TerrainFactory(new EarthSea(-1), new EarthPlains(), new EarthForest());
//print_r($factory->getSea());


class Contained{

}
class Container{
    public $contained;

    function __construct(){
        $this->contained = new Contained();
    }
    function __clone(){
        $this->contained = clone $this->contained;
    }
}


