<?php

/**
 * Команда (Command) относится к классу поведенческих паттернов. Команда представляет собой некоторое действие и его параметры. Суть паттерна в том, чтобы отделить инициатора и получателя команды.
 *
 * Этот паттерн широко используется в C# и Java для обработки событий возникающих в форме (GUI). Так как на PHP никто не занимается разработкой GUI приложений, то приводить подобный код я не стану.
 *
 * Для того что бы разобрать назначение участников этого паттерна, разберем известный и абсолютно отрешенный от реальности пример с лампочкой и выключателем.
 * Постановка задачи: разработать программу, которая будет принимать один аргумент из командной строки. Если передать ON - лампочка включается, если OFF - выключается.
 */
interface CommandInterface
{
    public function execute();
}

class TurnOnCommand implements CommandInterface
{
    protected $lamp;

    public function __construct(Lamp $lamp)
    {
        $this->lamp = $lamp;
    }

    public function execute()
    {
        $this->lamp->turnOn();
    }
}

class TurnOffCommand implements CommandInterface
{
    protected $lamp;

    public function __construct(Lamp $lamp)
    {
        $this->lamp = $lamp;
    }

    public function execute()
    {
        $this->lamp->turnOff();
    }
}

$lamp = new Lamp();
$on = new TurnOnCommand($lamp);
$on->execute();

/**
 * Понятное дело, что в таком виде их использовать неудобно. Давайте абстрагируемся от создания команды с помощью паттерна фабричный метод.
 */
class LampCommandFactory
{
    public function factory($type, Lamp $lamp)
    {
        if ($type == 'ON') {
            return new TurnOnCommand($lamp);
        }
        if ($type == 'OFF') {
            return new TurnOffCommand($lamp);
        }
        throw new RuntimeException('Cannot find command ' . $type);
    }
}

// ...
$lamp = new Lamp();
$factory = new LampCommandFactory(); // создаем фабрику
// фабрика вернет нам нужную команду
$factory->factory($argv[1], $lamp)->execute();

/**
 * В такой реализации есть еще что улучшить. Например команду TimeoutCommand будет довольно проблематично добавить в фабрику, так как для этой команды требуется дополнительный параметр $timeout, который мы получаем из командной строки.
 *
 * Что бы разрешить эту проблему, вместо фабрики используем регистр:
 */
class CommandRegistry
{
    private $registry = [];

    public function add(CommandInterface $command, $type)
    {
        $this->registry[$type] = $command;
    }

    public function get($type)
    {
        if (!isset($this->registry[$type])) {
            throw new RuntimeException('Cannot find command ' . $type);
        }
        return $this->registry[$type];
    }
}

// ...
$lamp = new Lamp();
$registry = new CommandRegistry();
$registry->add(new TurnOnCommand($lamp), 'ON');
$registry->add(new TurnOffCommand($lamp), 'OFF');
$registry->add(new SosCommand($lamp), 'SOS');
$registry->add(new TimeoutCommand($lamp, $argv[2]), 'TIMEOUT');
$registry->get($argv[1])->execute();
