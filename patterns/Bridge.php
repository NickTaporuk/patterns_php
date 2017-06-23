<?php

/**
 *Bridge (Мост) относиться к классу структурных паттернов. Он используется для отделения абстракции от ее реализации так, чтобы то и другое можно было изменять независимо.
 *
 * Если для одной абстракции возможно несколько реализаций, то обычно используют наследование. Однако такой подход не всегда удобен, так как наследование жестко привязывает реализацию к абстракции, что затрудняет независимую модификацию и усложняет их повторное использование.
 *
 * Давайте рассмотрим пример реализации системы, которая умеет отдавать данные сразу в нескольких представлениях: HTML, CLI, JSON, XML. Естественно мы хотим получить простую, расширяемую реализацию, которая позволила бы нам с легкостью это делать. В итоге приходим примерно к такой архитектуре:
 *
 * Используйте мост, когда:
 *
 * Хотите избежать постоянной привязки реализации к абстракции (например, когда реализацию необходимо выбирать во время выполнения).
 * Реализация и абстракция могут (или будут) дополняться через наследование
 * Изменение на абстракции или реализации не должны сказываться на клиенте
 * Количество классов начинает стремительно расти, не принося при этом реальной пользы
 * Вы хотите разделить одну реализации между разными абстракциями
 * Хотите повысить степень расширяемости
 * Хотите скрыть детали реализации от клиента
 * Родственным паттерном для моста является паттерн адаптер, который объединяет связанные части системы и предоставляет простой интерфейс. Правда мост, в отличие от адаптера, внедряется на этапе проектирования, а не на готовых рабочих системах.
 */
abstract class View
{
    protected
        $Imp = null;

    public function __construct()
    {
        // Здесь это сделано для упращения примера, в реальной же ситуации следует
        // использовать абстракную фабрику

        if (ENVIRONMENT == 'CLI') {
            $this->Imp = new ViewImplCLI();
        } else if (ENVIRONMENT == 'JSON') {
            $this->Imp = new ViewImplJSON();
        } else {
            throw new Exception('Unknown environment');
        }
    }

    protected function getImplementation()
    {
        return $this->Imp;
    }

    public function drawText($text)
    {
        return $this->getImplementation()->drawText($text);
    }

    public function drawLine()
    {
        return $this->getImplementation()->drawLine();
    }

    public function printResult()
    {
        print $this->getImplementation()->getResult();
    }
}

class ViewContent extends View
{
    public function printParagraph($text)
    {
        $this->drawText($text);
    }
}

class ViewTable extends View
{
    public function drawCell($text)
    {
        $this->drawLine();
        $this->drawText($text);
        $this->drawLine();
    }
}


abstract class ViewImpl
{
    abstract public function drawText($text);

    abstract public function drawLine();

    abstract public function getResult();

    abstract protected function appendResult($result);
}

class ViewImplCLI extends ViewImpl
{
    protected
        $result = "";

    public function drawLine()
    {
        $this->appendResult(str_repeat('-', 80) . PHP_EOL);
    }

    public function drawText($text)
    {
        $this->appendResult($text . PHP_EOL);
    }

    protected function appendResult($result)
    {
        $this->result .= $result;
    }

    public function getResult()
    {
        return $this->result;
    }

}

class ViewImplJSON extends ViewImpl
{
    protected
        $result = array();

    public function drawLine()
    {
        $this->appendResult(array(
            'type' => 'line'
        ));
    }

    public function drawText($text)
    {
        $this->appendResult(array(
            'type' => 'text',
            'text' => $text
        ));
    }

    protected function appendResult($result)
    {
        $this->result[] = $result;
    }

    public function getResult()
    {
        return json_encode($this->result);
    }
}

$Content = new ViewContent();
$Table = new ViewTable();

$Content->printParagraph('Hello world');
$Content->printResult();

$Table->drawCell('I am cell');
$Table->printResult();
