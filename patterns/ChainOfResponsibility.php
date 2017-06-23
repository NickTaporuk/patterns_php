<?php

/**
 * Цепочка обязанностей (Chain of Responsibility) относится к классу поведенческих паттернов. Служит для ослабления связи между отправителем и получателем запроса. При этом сам по себе запрос может быть произвольным.
 *
 * Паттерн не просто так называется цепочкой обязанностей. По сути это набор обработчиков, которые по очереди получают запрос, а затем решают обрабатывать его или нет. Если запрос не обработан, то он передается дальше по цепочке. Если же он обработан, то паттерн сам решает передавать его дальше или нет.
 *
 * Применяйте этот паттерн, если
 *  несколько объектов могут обработать сообщение
 *  вы не хотите явно указывать, кто обрабатывает сообщение
 *  набор объектов, которые способны обработать запрос задается в процессе выполнения
 */
abstract class AbstractHandler
{
    /**
     * @var AbstractHandler
     */
    protected $_next;

    /**
     * Send request by
     *
     * @param mixed $message
     */
    abstract public function sendRequest($message);

    /**
     * @param \AbstractHandler $next
     */
    public function setNext($next)
    {
        $this->_next = $next;
    }

    /**
     * @return \AbstractHandler
     */
    public function getNext()
    {
        return $this->_next;
    }
}

class ConcreteHandlerA extends AbstractHandler
{
    /**
     * @param mixed $message
     */
    public function sendRequest($message)
    {
        if ($message == 1) {
            echo __CLASS__ . "process this message";
        } else {
            if ($this->getNext()) {
                $this->getNext()->sendRequest($message);
            }
        }
    }
}

class ConcreteHandlerB extends AbstractHandler
{
    /**
     * @param mixed $message
     */
    public function sendRequest($message)
    {
        if ($message == 2) {
            echo __CLASS__ . "process this message";
        } else {
            if ($this->getNext()) {
                $this->getNext()->sendRequest($message);
            }
        }
    }
}

$handler = new ConcreteHandlerA();
$handler->setNext(new ConcreteHandlerB());
//$handler->getNext()->setNext(...);
$handler->sendRequest(1);
$handler->sendRequest(2);
/**
 * Давайте перейдем от абстрактного кода, к какому-либо примеру. Разработаем логгер ошибок с несколькими уровнями критичности. Все ошибки писать в лог, уровня critical будем отправлять на e-mail, а debug выводить на экран.
 */

abstract class Logger
{
    const DEBUG = 1;
    const CRITICAL = 2;
    const NOTICE = 4;
    protected $mask = 0;
    /**
     * @var Logger
     */
    protected $next;
    /**
     * @param $mask
     */
    public function __construct($mask)
    {
        $this->mask = $mask;
    }
    /**
     * @param string $message
     * @param int $priority
     */
    public function message($message, $priority)
    {
        if ($this->mask & $priority) {
            $this->_writeMessage($message);
        }
        if ($this->getNext()) {
            $this->getNext()->message($message, $priority);
        }
    }
    abstract protected function _writeMessage($message);
    /**
     * @param Logger $next
     */
    public function setNext(Logger $next)
    {
        $this->next = $next;
    }
    /**
     * @return Logger
     */
    public function getNext()
    {
        return $this->next;
    }
}
class ConsoleLogger extends Logger
{
    protected function _writeMessage($message)
    {
        echo $message . PHP_EOL;
    }
}
class FileLogger extends Logger
{
    protected function _writeMessage($message)
    {
        $f = fopen("error.log", "a");
        fwrite($f, $message . PHP_EOL);
        fclose($f);
    }
}
class EmailLogger extends Logger
{
    protected function _writeMessage($message)
    {
        mail("developer@example.com", "error", $message);
    }
}
$logger = new ConsoleLogger(Logger::NOTICE);
$file = new FileLogger(Logger::CRITICAL | Logger::DEBUG | Logger::NOTICE);
$mail = new EmailLogger(Logger::CRITICAL);
$logger->setNext($file);
$file->setNext($mail);
$logger->message("Notice message", Logger::NOTICE);
$logger->message("Debug message", Logger::DEBUG);
$logger->message("Critical error", Logger::CRITICAL);
