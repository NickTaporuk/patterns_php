<?php
/**
 * Шаблон Хранитель реализуется тремя объектами: “Создателем” (originator), “Опекуном” (caretaker) и “Хранитель” (memento).

Хранитель - это объект, который хранит конкретный снимок состояния некоторого объекта или ресурса: строки, числа, массива, экземпляра класса и так далее. Уникальность в данном случае подразумевает не запрет на существование одинаковых состояний в разных снимках, а то, что состояние можно извлечь в виде независимой копии. Любой объект, сохраняемый в Хранителе, должен быть полной копией исходного объекта, а не ссылкой на исходный объект. Сам объект Хранитель является «непрозрачным объектом» (тот, который никто не может и не должен изменять).

Создатель — это объект, который содержит в себе актуальное состояние внешнего объекта строго заданного типа и умеет создавать уникальную копию этого состояния, возвращая её, обёрнутую в объект Хранителя. Создатель не знает истории изменений. Создателю можно принудительно установить конкретное состояние извне, которое будет считаться актуальным. Создатель должен позаботиться о том, чтобы это состояние соответствовало типу объекта, с которым ему разрешено работать. Создатель может (но не обязан) иметь любые методы, но они не могут менять сохранённое состояние объекта.

Опекун управляет историей снимков состояний. Он может вносить изменения в объект, принимать решение о сохранении состояния внешнего объекта в Создателе, запрашивать от Создателя снимок текущего состояния, или привести состояние Создателя в соответствие с состоянием какого-то снимка из истории.
 */

class Memento
{
    /**
     * @var State
     */
    private $state;

    /**
     * @param State $stateToSave
     */
    public function __construct(State $stateToSave)
    {
        $this->state = $stateToSave;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }
}

class State
{
    const STATE_CREATED = 'created';
    const STATE_OPENED = 'opened';
    const STATE_ASSIGNED = 'assigned';
    const STATE_CLOSED = 'closed';

    /**
     * @var string
     */
    private $state;

    /**
     * @var string[]
     */
    private static $validStates = [
        self::STATE_CREATED,
        self::STATE_OPENED,
        self::STATE_ASSIGNED,
        self::STATE_CLOSED,
    ];

    /**
     * @param string $state
     */
    public function __construct(string $state)
    {
        self::ensureIsValidState($state);

        $this->state = $state;
    }

    private static function ensureIsValidState(string $state)
    {
        if (!in_array($state, self::$validStates)) {
            throw new \InvalidArgumentException('Invalid state given');
        }
    }

    public function __toString(): string
    {
        return $this->state;
    }
}

*/
class Ticket
{
    /**
     * @var State
     */
    private $currentState;

    public function __construct()
    {
        $this->currentState = new State(State::STATE_CREATED);
    }

    public function open()
    {
        $this->currentState = new State(State::STATE_OPENED);
    }

    public function assign()
    {
        $this->currentState = new State(State::STATE_ASSIGNED);
    }

    public function close()
    {
        $this->currentState = new State(State::STATE_CLOSED);
    }

    public function saveToMemento(): Memento
    {
        return new Memento(clone $this->currentState);
    }

    public function restoreFromMemento(Memento $memento)
    {
        $this->currentState = $memento->getState();
    }

    public function getState(): State
    {
        return $this->currentState;
    }
}

/**
 * Тест
 */


class MementoTest extends TestCase
{
    public function testOpenTicketAssignAndSetBackToOpen()
    {
        $ticket = new Ticket();

        // open the ticket
        $ticket->open();
        $openedState = $ticket->getState();
        $this->assertEquals(State::STATE_OPENED, (string) $ticket->getState());

        $memento = $ticket->saveToMemento();

        // assign the ticket
        $ticket->assign();
        $this->assertEquals(State::STATE_ASSIGNED, (string) $ticket->getState());

        // now restore to the opened state, but verify that the state object has been cloned for the memento
        $ticket->restoreFromMemento($memento);

        $this->assertEquals(State::STATE_OPENED, (string) $ticket->getState());
        $this->assertNotSame($openedState, $ticket->getState());
    }
}