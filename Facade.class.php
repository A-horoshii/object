<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 15.07.2016
 * Time: 10:49
 */

function getProductFileLines($file){
    return file($file);
}

function getProductObjectFromID($id, $product_name){
    // реализация получения продуктов с БД
    return new Product($id,$product_name);
}

function getNameFromLine($line){
    if (preg_match("/.*-(.*)\s\d+/", $line, $array)){
        return str_replace('_',' ', $array[1]);
    }
    return '';
}

function getIDFromLine($line){
    if (preg_match("/^(\d{1,3})-/", $line, $array)){
        return $array[1];
    }
    return -1;
}

class Product
{
    public $id;
    public $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }
}


class ProductFacade{
    private $products = [];

    function __construct($file){
        $this->file = $file;
        $this->compile();
    }

    private function compile(){
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line){
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromID($id, $name);
        }


    }
    function getProducts(){
        return $this->products;
        }
    function getProduct($id){
        return $this->products[$id];
    }
}