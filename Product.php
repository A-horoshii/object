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
            throw new Exception("Функция обратного выхова не вызывается");
        }
        $this->callbacks[] = $callback;
    }

    function sale($product){
        print "{$product->name}:обрабатывается...\n";
        foreach ($this->callbacks as $callback){
            call_user_func($callback, $product);
        }
    }
}
$logger = function($product){
    print "Записываем ({$product->name})\n";
};
$processor = new ProcessSale();
$processor->registerCallback($logger);

$processor->sale(new Product("Туфли", 6));
print "\n";
$processor->sale(new Product("Кофе", 6));

$method = 'sale';
