<?php
/**
 * NullObject не шаблон из книги Банды Четырёх, но схема, которая появляется достаточно часто, чтобы считаться паттерном. Она имеет следующие преимущества:

Клиентский код упрощается
Уменьшает шанс исключений из-за нулевых указателей (и ошибок PHP различного уровня)
Меньше дополнительных условий — значит меньше тесткейсов
Методы, которые возвращают объект или Null, вместо этого должны вернуть объект NullObject. Это упрощённый формальный код, устраняющий необходимость проверки if (!is_null($obj)) { $obj->callSomething(); }, заменяя её на обычный вызов $obj->callSomething();.
 *
 * Примеры:
 *  Symfony2: null logger of profiler
 *  Symfony2: null output in Symfony/Console
 *  null handler in a Chain of Responsibilities pattern
 *  null command in a Command pattern
 */
interface LoggerInterface
{
    public function log(string $str);
}

class PrintLogger implements LoggerInterface
{
    public function log(string $str)
    {
        echo $str;
    }
}

class NullLogger implements LoggerInterface
{
    public function log(string $str)
    {
        // do nothing
    }
}

class Service
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * do something ...
     */
    public function doSomething()
    {
        // notice here that you don't have to check if the logger is set with eg. is_null(), instead just use it
        $this->logger->log('We are in '.__METHOD__);
    }
}

/**
 * Test
 */
class LoggerTest extends TestCase
{
    public function testNullObject()
    {
        $service = new Service(new NullLogger());
        $this->expectOutputString('');
        $service->doSomething();
    }

    public function testStandardLogger()
    {
        $service = new Service(new PrintLogger());
        $this->expectOutputString('We are in Service::doSomething');
        $service->doSomething();
    }
}