<?php
/**
 * Created by PhpStorm.
 * User: horoshie
 * Date: 28.12.2016
 * Time: 12:54
 */
trait PriceUtilities
{
    private $tax_rate = 17;

    function calculateTax($price){
        return (($this->tax_rate/100)*$price);
    }
}

trait TaxTools{
    function calculateTax($price){
        return 222;
    }
}
class ShopProduct{
    use PriceUtilities;
}

abstract class Service{

}

class UtilityService extends Service {
    use PriceUtilities, TaxTools{
        TaxTools::calculateTax insteadof PriceUtilities;
    }
}
$p = new UtilityService();
print $p->calculateTax(123);