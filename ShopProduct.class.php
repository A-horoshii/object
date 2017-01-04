<?php
class ShopProduct {
    private  $title;
    private $producerMainName;
    private $producerFirstName;
    protected  $price;
    private $discount = 0;
    private $id = 0;

    public function __construct($title, $firstName, $mainName, $price) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;


    }

    public function getProducerFirstName(){
        return $this->producerFirstName;
    }

    public function getProducerMainName(){
        return $this->producerMainName;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getProducer() {
        return "{$this->producerFirstName} "
                ."{$this->producerMainName}";
    }

    public function getSummaryLine() {
        $base = "$this->title ({$this->producerMainName},";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }

    public function setDiscount($num) {
        $this->discount = $num;
    }

    public function getDiscount() {
       return $this->discount;
    }

    public function getPrice(){
        return($this->price - $this->discount);
    }
    public function setID($id) {
        $this->id = $id;
    }
    public static function getInstance($id, PDO $pdo){

        $stmt = $pdo->prepare("SELECT * FROM products where id=?");
        $result = $stmt->execute(array($id));

        $row = $stmt->fetch();

        if (empty($row)){ return NULL;}
        if ($row['type'] == "book") {
            $product = new BookProduct(
                                        $row['title'],
                                        $row['firstname'],
                                        $row['mainname'],
                                        $row['price'],
                                        $row['numpages']);
        }else if($row['type'] == "cd"){
            $product = new CDProduct(
                                        $row['title'],
                                        $row['firstname'],
                                        $row['mainname'],
                                        $row['price'],
                                        $row['playlength']);
        }else{
            $product = new ShopProduct(
                                        $row['title'],
                                        $row['firstname'],
                                        $row['mainname'],
                                        $row['price']);
        }
        $product->setID($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
    }
}

class CDProduct extends ShopProduct {
    private $playLength = 0;
    public function __construct($title, $firstName, $mainName, $price, $playLength) {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }

    public function getPlayLength() {
        return $this->playLength;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": Время звучания - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {
    private  $numPages = 0;

    public function __construct($title, $firstName, $mainName, $price, $numPages) {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    public function getNumberOfPages() {
        return $this->numPages;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": {$this->numPages} стр.";
        return $base;
    }

    public function getPrice(){
        return $this->price;
    }
}

abstract class ShopProductWriter
{
    protected  $products = array();

    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }

    abstract public function write();
}

class XmlProductWriter extends ShopProductWriter{
    public function write(){
        $str ='<?xml version="1.0" encodin="UTF-8" ?>'."\n";
        $str .="<products>\n";
        foreach($this->products as $shopProduct){
            $str .= "\t<product title=\"{$shopProduct->getTitle()}\">\n";
            $str .= "\t\t<summary>\n";
            $str .= "\t\t{$shopProduct->getSummaryLine()}\n";
            $str .= "\t\t</summary>\n";
            $str .= "\t</product>\n";
        }
        $str .="</products>\n";
        print $str;
    }
}

class TextProductWriter extends ShopProductWriter{
    public function write(){
        $str = "ТОВАРЫ:";
        foreach($this->products as $shopProduct){
            $str .= $shopProduct->getSummaryLine()."\n";
        }
        print $str;
    }
}

class Wrong{}
//$product1 = new Wrong();  //выведет ошибку

//$product1 = new BookProduct("Собачье сердец", "Булгаков", "Михаил", 5.99, 260);
//$product2 = new BookProduct("Собачье сердец", "Булгаков", "Михаил", 5.99, 260);
//$product3 = new CDProduct("Собачье сердец", "Булгаков", "Михаил", 5.99, 260);
//$writer = new ShopProductWriter();
//$writer->addProduct($product1);
//$writer->addProduct($product2);
//$writer->addProduct($product3);
//$writer->write();
//
//print "<br>{$product1->getSummaryLine()}";
//print "<br>{$product3->getSummaryLine()}";

//$dsn ="sqlite:product.db";
//
//$pdo = new PDO($dsn, null, null);
//
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$obj = ShopProduct::getInstance(2,$pdo);
//var_dump($obj);
$prod_class = new ReflectionClass('CDProduct');
