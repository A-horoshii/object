<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 26.07.2016
 * Time: 14:00
 */

abstract class Command {
    abstract function execute(CommandContext $context);
}
class LoginCommand extends Command{
    function execute(CommandContext $context){
        $manager = Registry::getAccessManager();
        $user = $context->get('username');
        $pass = $context->get('pass');
        $user_obj = $manager->login($user, $pass);
        if(is_null($user_obj)){
            $context->setError($manager->getErorr());
            return false;
        }
        $context->addParam($user, $pass);
        return true;
    }
}