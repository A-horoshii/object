<?php
class Product {
    public $name;
    public $price;

    function __construct($name, $price){
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale{
    private $callbacks;

    function registerCallback($callback){
        if(!is_callable($callback)){
            throw new Exception("������� ��������� ������ �� ����������");
        }
        $this->callbacks[] = $callback;
    }

    function sale($product){
        print "{$product->name}:��������������...\n";
        foreach ($this->callbacks as $callback){
            call_user_func($callback, $product);
        }
    }
}
$logger = function($product){
    print "���������� ({$product->name})\n";
};
$processor = new ProcessSale();
$processor->registerCallback($logger);

$processor->sale(new Product("�����", 6));
print "\n";
$processor->sale(new Product("����", 6));

$method = 'sale';
