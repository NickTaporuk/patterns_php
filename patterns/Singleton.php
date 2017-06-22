<?php

/**
 * name pattern
 * SINGELTON
 * Description
 *  Гарантирует, что у класса есть только один экземпляр, и предоставляет к нему глобальную точку доступа.Существенно то, что можно пользоваться именно экземпляром класса, так как при этом во многих случаяхстановится доступной более широкая функциональность. Например, к описанным компонентам класса можнообращаться через интерфейс, если такая возможность поддерживается языком.
 * php code example
 */
Interface ISingleton
{
}

class Singleton implements ISingleton
{
    private $props = [];
    private static $_instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$_instance)) self::$_instance = new self();

        return self::$_instance;
    }

    public function foo()
    {
        var_dump(__CLASS__ . PHP_EOL . __METHOD__ . PHP_EOL . __LINE__);
    }
}

$s = (Singleton::getInstance())->foo();