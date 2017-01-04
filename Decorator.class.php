<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 14.07.2016
 * Time: 14:49
 */

abstract class Tile
{
    abstract function getWealthFactor();
}

class Plains extends Tile
{
    private  $wealth_factor = 2;
    function getWealthFactor(){
        return $this->wealth_factor;
    }
}

abstract class TileDecorator extends Tile
{
    protected $tile;

    function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator
{
    function getWealthFactor(){
        return $this->tile->getWealthFactor()+2;
    }
}

class PollutedDecorator extends TileDecorator
{
    function getWealthFactor(){
        return $this->tile->getWealthFactor()-4;
    }
}

//$tile1 = new PollutedDecorator(new DiamondDecorator(new Plains()));
//print $tile1->getWealthFactor();


//<->

class RequestHelper{}
abstract class ProcessRequest
{
    abstract function process(RequestHelper $req);
}

class MainProcess extends ProcessRequest{
    function process(RequestHelper $req){
        print __CLASS__." :do it";
    }
}

abstract class DecorateProcess extends ProcessRequest{
    protected $process_request;

    function __construct(ProcessRequest $pr){
        $this->process_request = $pr;
    }
}

class LogDecorate extends DecorateProcess{
    function process(RequestHelper $req){
        print __CLASS__.":register query\n";
        $this->process_request->process($req);
    }
}

$process = new LogDecorate(new MainProcess());
$process->process(new RequestHelper());