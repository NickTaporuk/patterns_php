<?php

/**
 *Composite (Компоновщик) относиться к классу структурных паттернов. Он используется для компоновки объектов в древовидные структуры для представления иерархий, позволяя одинаково трактовать индивидуальные и составные объекты.
 */
class ComponentException extends Exception
{
}

;

abstract class Component
{
    protected $_children = array();

    abstract public function add(Component $Component);

    abstract public function remove($index);

    abstract public function getChild($index);

    abstract public function getChildren();

    abstract public function operation();
}

class Composite extends Component
{
    public function add(Component $Component)
    {
        $this->_children[] = $Component;
    }

    public function getChild($index)
    {
        if (!isset($this->_children[$index])) {
            throw new ComponentException("Child not exists");
        }
        return $this->_children[$index];
    }

    public function operation()
    {
        print "I am composite. I have " . count($this->getChildren()) . " children\n";
        foreach ($this->getChildren() as $Child) {
            $Child->operation();
        }
    }

    public function remove($index)
    {
        if (!isset($this->_children[$index])) {
            throw new ComponentException("Child not exists");
        }
        unset($this->_children[$index]);
    }

    public function getChildren()
    {
        return $this->_children;
    }
}

class Leaf extends Component
{
    public function add(Component $Component)
    {
        throw new ComponentException("I can't append child to myself");
    }

    public function getChild($index)
    {
        throw new ComponentException("Child not exists");
    }

    public function operation()
    {
        print "I am leaf\n";
    }

    public function remove($index)
    {
        throw new ComponentException("Child not exists");
    }

    public function getChildren()
    {
        return array();
    }
}
