<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 13.01.2017
 * Time: 11:27
 */

abstract class Command {
    abstract function execute(CommandContext $context);
}
class FeedbackCommand extends Command{
    function execute(CommandContext $context){
        $msgSystem = Registry::getMessageSystem();
        $email = $context->get('email');
        $msg = $context->get('msg');
        $topic = $context->get('topic');
        $result = $msgSystem->send($email, $msg, $topic);
        if(!$result){
            $context->setError($msgSystem->getError());
            return false;
        }
        return true;
    }
}