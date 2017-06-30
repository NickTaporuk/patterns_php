<?php
class Car {
    private $speed;
    private $color;
    private $doors;

    public function setSpeed($speed){
        $this->speed = $speed;
        return $this;
    }

    public function setColor($color)  {
        $this->color = $color;
        return $this;
    }

    public function setDoors($doors) {
        $this->doors = $doors;
        return $this;
    }
}

// Обычная реализация
$myCar2 = new Car();
$myCar2->setSpeed(100);
$myCar2->setColor('blue');
$myCar2->setDoors(5);

// Текучий интерфейс
$myCar = new Car();
$myCar->setSpeed(100)->setColor('blue')->setDoors(5);