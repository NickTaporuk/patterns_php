<?php

/**
 * Обеспечить взаимодействие множества объектов, сформировав при этом слабую связанность и избавив объекты от необходимости явно ссылаться друг на друга.
 *
 * Создать объект, инкапсулирующий способ взаимодействия множества объектов.
 *
 * Устраняется связанность между "Коллегами", централизуется управление.
 *
 * Описание :
 *  "Посредник" определяет интерфейс для обмена информацией с объектами "Коллеги", "Конкретный посредник" координирует действия объектов "Коллеги". Каждый класс "Коллеги" знает о своем объекте "Посредник", все "Коллеги" обмениваются информацией только с посредником, при его отсутствии им пришлось бы обмениваться информацией напрямую. "Коллеги" посылают запросы посреднику и получают запросы от него. "Посредник" реализует кооперативное поведение, пересылая каждый запрос одному или нескольким "Коллегам".
 */
abstract class Mediator
{
    public abstract function send($message, Colleague $colleague);
}

abstract class Colleague
{
    protected $mediator;

    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

    public function send($message)
    {
        $this->mediator->send($message, $this);
    }

    /**
     * Обработка полученного сообщения реализуется каждым конкретным
     * наследником
     * @param string message получаемое сообщение
     */
    public abstract function notify($message);
}

class ConcreteMediator extends Mediator
{
    private $colleague1;
    private $colleague2;

    public function setColleague1(ConcreteColleague1 $colleague)
    {
        $this->colleague1 = $colleague;
    }

    public function setColleague2(ConcreteColleague2 $colleague)
    {
        $this->colleague2 = $colleague;
    }

    public function send($message, Colleague $colleague)
    {
        if ($colleague == $this->colleague1) {
            $this->colleague2->notify($message);
        } else {
            $this->colleague1->notify($message);
        }
    }
}


//коллега 1
class ConcreteColleague1 extends Colleague
{
    public function notify($message)
    {
        echo sprintf("Collegue1 gets message: %s\n", $message);
    }
}

//коллега 2
class ConcreteColleague2 extends Colleague
{
    public function notify($message)
    {
        echo sprintf("Collegue2 gets message: %s\n", $message);
    }
}


$mediator = new ConcreteMediator();

$collegue1 = new ConcreteColleague1($mediator);
$collegue2 = new ConcreteColleague2($mediator);

$mediator->setColleague1($collegue1);
$mediator->setColleague2($collegue2);

$collegue1->send('How are you ?');
$collegue2->send('Fine, thanks!');
