<?php

abstract class CommsManager
{
    const APPT = 1;
    const TTD = 2;
    const CONTACT = 3;

    abstract function getHeaderText();
    abstract function make($flag_int);
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
    function getHeaderText(){}
    function make($flag_ing){
        switch ($flag_ing){
            case self::APPT:
                return new  BloggsApptEncoder();
            case self::TTD:
                return new BloggsTtdEncoder();
            case self::CONTACT:
                return new BloggsContactEncoder();
        }
    }
    function getFooterText(){}
}

