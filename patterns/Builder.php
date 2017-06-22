<?php

/**
 * Паттерн Builder является паттерном создания объектов (creational pattern). Суть его заключается в том, чтобы отделитьпроцесс создания некоторого сложного объекта от его представления. Таким образом, можно получать различныепредставления объекта, используя один и тот же “технологический” процесс.
 *
 * Цель
 *
 * Отделяет конструирование сложного объекта от его представления, так что в результате одного и того же процессаконструирования могут получаться разные представления.
 *
 * Плюсы
 *
 * позволяет изменять внутреннее представление продукта;
 * изолирует код, реализующий конструирование и представление;
 * дает более тонкий контроль над процессом конструирования.
 * Применение
 *
 * алгоритм создания сложного объекта не должен зависеть от того, из каких частей состоит объект и как онистыкуются между собой;
 * процесс конструирования должен обеспечивать различные представления конструируемого объекта.
 */

namespace Patterns\Examples;

class Phone
{
    private $_name;
    private $_os;

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setOs($os)
    {
        $this->_os = $os;
    }
}

abstract class BuilderPhone
{
    protected $_phone;

    public function getPhone()
    {
        return $this->_phone;
    }

    public function createPhone()
    {
        $this->_phone = new Phone();
    }

    abstract public function buildName();

    abstract public function buildOs();
}

class BuilderNexus4 extends BuilderPhone
{
    public function buildName()
    {
        $this->_phone->setName('Nexus4');
    }

    public function buildOs()
    {
        $this->_phone->setOs("Android");
    }
}

class BuilderIphone5 extends BuilderPhone
{
    public function buildName()
    {
        $this->_phone->setName('Iphone5');
    }

    public function buildOs()
    {
        $this->_phone->setOs("iOs");
    }
}

class Chooser
{
    private $_builderPhone;

    public function setBuilderPhone(BuilderPhone $mp)
    {
        $this->_builderPhone = $mp;
    }

    public function getPhone()
    {
        return $this->_builderPhone->getPhone();
    }

    public function constructPhone()
    {
        $this->_builderPhone->createPhone();
        $this->_builderPhone->buildName();
        $this->_builderPhone->buildOs();
    }
}

$user = new Chooser();
$google = new BuilderNexus4();
$apple = new BuilderIphone5();
$user->setBuilderPhone($google);
$user->constructPhone();

$realPhone = $user->getPhone() ;
