<?php
/**
 * Created by PhpStorm.
 * User: horoshie
 * Date: 28.12.2016
 * Time: 12:54
 */
//trait PriceUtilities
//{
//    private $tax_rate = 17;
//
//    function calculateTax($price){
//        return (($this->tax_rate/100)*$price);
//    }
//}

trait PriceUtilities{

    function calculateTax($price){
        return(($this->getTaxRate()/100)*$price);
    }
    abstract function getTaxRate();
}
trait TaxTools{
    function calculateTax($price){
        return 222;
    }
}
class ShopProduct{
    use PriceUtilities;
    function getTaxRate()
    {
        return 12;
    }
}

abstract class Service{

}

class UtilityService extends Service {
    use PriceUtilities, TaxTools{
        TaxTools::calculateTax insteadof PriceUtilities;
        PriceUtilities::calculateTax as basicTax;
    }
    function getTaxRate()
    {
      return 17;
    }
}
$p = new UtilityService();
//print $p->calculateTax(123);
print $p->basicTax(1223);