<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 19.07.2016
 * Time: 15:57
 */

abstract class Question{
    protected $prompt;
    protected $marker;

    function __construct($prompt, Marker $marker){
        $this->marker = $marker;
        $this->prompt = $prompt;
    }

    function mark($response){
        return $this->marker->mark($response);
    }
}

class TextQuestion extends Question{


}

class AVQuestion extends Question{

}

abstract class Marker{

    protected $test;

    function  __construct($test){
        $this->test = $test;
    }
    abstract  function  mark($response);
}

class MarkLogicMarker extends Marker{
    private  $engine;

    function __construct($test){
        parent::__construct($test);
//        $this->engine = new MarkParse($test);
    }

    function mark($response){
//        return $this->engine->evalute($response);
        return true;
    }
}

class MatchMarker extends Marker{

    function mark($response){
        return ($this->test == $response);
    }
}

class RegexpMarker extends Marker{
    function mark($response){
        return (preg_match($this->test, $response));
    }
}

// ��� ��� ������� �������

$markers = array(new RegexpMarker("/�.��/"), new MatchMarker("����"), new MarkLogicMarker('$input equals "����"'));

foreach ($markers as $marker){
    print get_class($marker)." <br>";
    $question = new TextQuestion("������� ����� � ��������", $marker);
    foreach (array("����", "������") as $response){
        print "--  $response";
        if($question->mark($response)){
            print " ���������<br>";
        }else{
            print " �����������!<br>";
        }
    }
}