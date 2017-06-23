<?php

/**
 * Decorator (Декоратор) относиться к классу структурных паттернов. Он используется для динамического расширения функциональности объекта. Является гибкой альтернативой наследованию.
 *
 * Сущность работы паттерна декоратор заключается в "оборачивании" готового объекта новым функционалом, при этом весь оригинальный интерфейс объекта остается доступным (декоратор переадресует все запросы объекту). Смысл заключается в том, чтобы можно было безболезненно комбинировать различные декораторы в произвольном порядке, навешивая их на различные объекты. В некотором роде, это похоже на технологию traits, за исключением того, что декораторы динамически навешиваются на объект, а traits статически на класс.
 *
 *  Большая гибкость
 *  Легкие классы на верхних уровнях абстракции
 *  Множество мелких объектов
 */

abstract class Component
{
    abstract public function operation();
}

class ConcreteComponent extends Component
{
    public function operation()
    {
        return 'I am component';
    }
}

abstract class Decorator extends Component
{
    protected
        $_component = null;

    public function __construct(Component $component)
    {
        $this->_component = $component;
    }

    protected function getComponent()
    {
        return $this->_component;
    }

    public function operation()
    {
        return $this->getComponent()->operation();
    }
}

class ConcreteDecoratorA extends Decorator
{
    public function operation()
    {
        return '<a>' . parent::operation() . '</a>';
    }
}

class ConcreteDecoratorB extends Decorator
{
    public function operation()
    {
        return '<strong>' . parent::operation() . '</strong>';
    }
}

$Element = new ConcreteComponent();
$ExtendedElement = new ConcreteDecoratorA($Element);
$SuperExtendedElement = new ConcreteDecoratorB($ExtendedElement);
print $SuperExtendedElement->operation(); // <strong><a>I am component</a></strong>