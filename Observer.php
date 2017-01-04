<?php
/**
 * Created by PhpStorm.
 * User: horoshii
 * Date: 04.01.2017
 * Time: 12:15
 */
interface Observer{
    function update(Observable $observable);
}

interface  Observable{
    function attach(Observer  $observer);
    function detach(Observer  $observer);
    function notify();
}

abstract class LoginObserver implements Observer{
    private $login;
    function __construct(Login $login)
    {
        $this->login = $login;
        $login->attach($this);
    }
    function update(Observable $observable)
    {
        if($observable === $this->login){
            $this->doUpdate($observable);
        }
    }
    abstract function doUpdate(Login $login);
}

class Login implements Observable{
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;

    private $status = array();

    private $observers;

    function __construct()
    {
        $this->observers = array();
    }
    function attach(Observer $observer)
    {
        $this->observers[]= $observer;
    }

    function detach(Observer $observer)
    {
        // TODO: Implement detach() method.
        $new_observers = array();
        foreach ($this->observers as $obs){
            if($obs!== $observer){
                $new_observers[] = $obs;
            }
        }
        $this->observers = $new_observers;
    }

    function notify()
    {
        // TODO: Implement notify() method.
        foreach ($this->observers as $obs){
            $obs->update($this);
        }
    }

    function handleLogin($user, $pass, $ip){
        switch (rand(1,3)){
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $ret = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $ret = false;
                break;
        }
        $this->notify();
        return $ret;
    }

    function setStatus($status, $user, $ip){
        $this->status = array($status, $user, $ip);
    }

    function getStatus(){
        return $this->status;
    }
}

class SecurityMonitor extends LoginObserver{
    function doUpdate(Login $login)
    {
        // TODO: Implement update() method.
        $status = $login->getStatus();
        if($status[0] == Login::LOGIN_WRONG_PASS){
            // TODO: Отправка почты админку
            print __CLASS__. ":\t Отпаравка почты админу";
        }
    }
}

$login = new Login();
new SecurityMonitor($login);
$login->handleLogin('root', 123, '123123');

