<?php
/**
 *  Facade (Фасад) относиться к классу структурных паттернов. Представляет собой унифицированный интерфейс вместо набора интерфейсов некоторой подсистемы. Паттерн фасад определяет интерфейс более высокого уровня, который упрощает использование подсистем.

Разбиение на подсистемы сложной системы позволяет упростить процесс проектирования, а также помогает максимально снизить зависимости одной подсистемы от другой. Однако это приводит к тому, что использовать такие подсистемы вместе становиться довольно сложно. Один из способов решения этой проблемы является ввод паттерна фасад.

Это один из тех паттернов, у которого нет четкой реализации, так как она зависит от конкретной системы.
 *
 * Используйте этот паттерн, если вы хотите:
 *  Предоставить простой интерфейс к сложной подсистеме
 *  Отделить систему от клиентов и от других систем
 *  Разделить подсистему на независимые слои (точка входа каждого слоя - фасад)
 *  Повысить переносимость
 */

/**
 * SystemA
 */
class Bank
{
    public function openTransaction() {}
    public function closeTransaction() {}
    public function transferMoney($amount) {}
}
/**
 * SystemB
 */
class Client
{
    public function openTransaction() {}
    public function closeTransaction() {}
    public function transferMoney($amount) {}
}
/**
 * SystemC
 */
class Log
{
    public function logTransaction() {}
}
class Facade
{
    public function transfer($amount)
    {
        $Bank = new Bank();
        $Client = new Client();
        $Log = new Log();
        $Bank->openTransaction();
        $Client->openTransaction();
        $Log->logTransaction('Transaction open');
        $Bank->transferMoney(-$amount);
        $Log->logTransaction('Transfer money from bank');
        $Client->transferMoney($amount);
        $Log->logTransaction('Transfer money to client');
        $Bank->closeTransaction();
        $Client->closeTransaction();
        $Log->logTransaction('Transaction close');
    }
}
// Client code
$Transfer = new Facade();
$Transfer->transfer(1000);