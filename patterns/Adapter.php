<?php
/**
Adapter (Адаптер) относиться к классу структурных паттернов. Он используется для преобразования одного интерфейса в другой, необходимый клиенту. Адаптер обеспечивает совместимость несовместимых интерфейсов, реализуя прослойку.

Принцип работы

Адаптер наследует открытым способом целевой интерфейс (назовем его Target), и закрытым способом адаптируемый интерфейс (Adaptee). В реализации методов целевого интерфейса происходит перенаправление (делегирование) запросов классу с адаптируемым интерфейсом
*/

// Целевой интерфейс, клиент умеет работать только с ним
interface iTarget
{
    public function query();
}
// Адаптируемый интерфейс. Клиент с ним не умеет работать, но очень хочет
interface iAdaptee
{
    public function request();
}
// Класс, реализующий адаптирумым интерфейс
class Adaptee implements iAdaptee
{
    public function request()
    {
        return __CLASS__ . "::" . __METHOD__;
    }
}
class Adapter implements iTarget
{
    protected
        $adaptee = null;
    public function __construct()
    {
        $this -> adaptee = new Adaptee();
    }
    public function query()
    {
        return $this -> adaptee -> request();
    }
}
$Target = new Adapter();
print $Target -> query(); // "Adaptee::request"