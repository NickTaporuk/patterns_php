<?php
/**
 * Итератор (Iterator) относится к классу поведенческих паттернов. Используется в составных объектах. Предоставляет доступ к своим внутренним полям не раскрывая их структуру.
 * Зачастую этот паттерн используется вместо массива объектов, чтобы не только предоставить доступ к элементам, но и наделить некоторой логикой. Это может быть ограничение доступа, сортировка или любая другая операция над множеством объектов.
 *
 * Как видите, структура паттерна очень простая. Iterator это общий интерфейс, позволяющий реализовать произвольную логику итераций. IteratorAggregate более общий, позволяющий использовать готовые итераторы.
 * Немного о методах интерфейса Iterator
 *  Метод current() возвращает текущий элемент
 *  Метод next() перемещает указатель на следующий элемент
 *  Метод key() возвращает индекс текущего элемента
 *  Метод valid() проверяет, существует ли текущий элемент или нет
 *  Метод rewind() переводит указатель текущего элемента на первый
 *  Таким образом, реализуя все методы итератора можно будет делать так:
 */
foreach($iterator as $key => $value) {
    // do something
}

/**
 * Class MyArrayIterator
 */
class MyArrayIterator implements Iterator
{

    /**
     * @var array
     */
    protected $array = array();

    /**
     * MyArrayIterator constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->array);
    }

    /**
     *
     */
    public function next()
    {
        next($this->array);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->array);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->array[$this->key()]);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->array);
    }
}

/**
 * Class MyIteratorAggregate
 */
class MyIteratorAggregate implements IteratorAggregate
{
    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator([1, 2, 3, 4]);
    }
}
// Example
$iterator = new MyArrayIterator([1, 2, 3, 5]);
// output array
var_dump(iterator_to_array($iterator));
// output all values of array
foreach ($iterator as $value) {
    var_dump($value);
}
// aggregate
$iteratorAggregate = new MyIteratorAggregate();

foreach ($iteratorAggregate as $value) {
    var_dump($value);
}
