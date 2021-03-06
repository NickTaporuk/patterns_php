<?php

/**
 * Цель
 *
 * Задаёт виды создаваемых объектов с помощью экземпляра-прототипа и создаёт новые объекты путём копированияэтого прототипа.
 *
 * Проще говоря, это паттерн создания объекта через клонирование другого объекта вместо создания черезконструктор.
 *
 * Применение
 *
 * Паттерн используется чтобы:
 *
 * избежать дополнительных усилий по созданию объекта стандартным путем (имеется в виду использованиеключевого слова 'new', когда вызывается конструктор не только самого объекта, но и конструкторы всейиерархии предков объекта), когда это непозволительно дорого для приложения.
 * избежать наследования создателя объекта (object creator) в клиентском приложении, как это делает паттернАбстрактная фабрика.
 * Используйте этот шаблон проектирования, когда система не должна зависеть от того, как в ней создаются,компонуются и представляются продукты:
 *
 * инстанцируемые классы определяются во время выполнения, например с помощью динамической загрузки;
 * для того чтобы избежать построения иерархий классов или фабрик, параллельных иерархии классовпродуктов;
 * экземпляры класса могут находиться в одном из нескольких различных состояний. Может оказаться удобнееустановить соответствующее число прототипов и клонировать их, а не инстанцировать каждый раз классвручную в подходящем состоянии.
 */
class Single
{
    public function __clone()
    {
    }
}

/**
 * Class Prototype
 */
class Prototype
{
    public function getClone(Single $single)
    {
        return clone $single;
    }
}

$prototype = new Prototype();
$singleArray[] = $prototype->getClone(newSingle());