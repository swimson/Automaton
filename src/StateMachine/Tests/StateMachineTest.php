<?php

namespace StateMachine\Tests;

use StateMachine\State;
use StateMachine\StateMachine;
use StateMachine\Transition;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \StateMachine\StateMachine
     */
    protected $stateMachine;

    /**
     * @var \StateMachine\State
     */
    protected $state1;

    /**
     * @var \StateMachine\State
     */
    protected $state2;

    /**
     * @var \StateMachine\Transition
     */
    protected $transition1;

    /**
     * @var \StateMachine\Transition
     */
    protected $transition2;

    /**
     * @var \StateMachine\Transition
     */
    protected $transition3;

    /**
     * @var \StateMachine\State
     */
    protected $state3;

    public function setup()
    {
        $this->stateMachine = new StateMachine();
        $this->state1       = new State('state1');
        $this->state2       = new State('state2');
        $this->state3       = new State('state3');
    }

    public function setupMachine1() {
        /**
         * Transitions
         * 1 :=> 2
         * 2 := 1, 3
         * 3: => No transitions
         */

        $this->transition1 = new Transition($this->state1, 'event1-2', $this->state2);
        $this->transition2 = new Transition($this->state2, 'event2-1', $this->state1);
        $this->transition3 = new Transition($this->state2, 'event2-3', $this->state3);

        $this->state1->addTransition($this->transition1);
        $this->state2->addTransition($this->transition2);
        $this->state2->addTransition($this->transition3);

        $this->stateMachine->addState($this->state1);
        $this->stateMachine->addState($this->state2);
        $this->stateMachine->addState($this->state3);
    }

    public function testInterface()
    {
        $this->assertInstanceOf('StateMachine\StateMachineInterface', $this->stateMachine);
    }

    public function testAddState()
    {
        $state1       = $this->state1;
        $stateMachine = $this->stateMachine;

        $stateMachine->addState($state1);
        $this->assertEquals(array($state1->getName() => $state1), $stateMachine->getAllStates());
    }

    /**
     * @expectedException \StateMachine\Exception\AlterStateMachineException
     */
    public function testExceptionOnAddingState()
    {
        $state1       = $this->state1;
        $state2       = $this->state2;
        $stateMachine = $this->stateMachine;

        $stateMachine->addState($state1);
        $stateMachine->boot($state1);
        $stateMachine->addState($state2); // exception thrown
    }

    public function testRemoveState()
    {
        $state1       = $this->state1;
        $stateMachine = $this->stateMachine;

        $stateMachine->addState($state1);
        $this->assertEquals(array($state1->getName() => $state1), $stateMachine->getAllStates());
        $stateMachine->removeState($state1);
        $this->assertEquals(array(), $stateMachine->getAllStates());
    }

    /**
     * @expectedException \StateMachine\Exception\AlterStateMachineException
     */
    public function testExceptionOnRemovingState()
    {
        $this->stateMachine->addState($this->state1);
        $this->stateMachine->boot($this->state1);
        $this->stateMachine->removeState($this->state1);
    }

    public function testGetAllStates()
    {
        $this->assertEquals(array(), $this->stateMachine->getAllStates());
        $this->stateMachine->addState($this->state1);
        $this->stateMachine->addState($this->state2);

        $this->assertEquals(
            array(
                $this->state1->getName() => $this->state1,
                $this->state2->getName() => $this->state2
            ),
            $this->stateMachine->getAllStates()
        );
    }

    public function testGetState()
    {
        $this->stateMachine->addState($this->state1);
        $this->stateMachine->addState($this->state2);
        $this->stateMachine->boot($this->state1);
        $this->assertEquals($this->state1, $this->stateMachine->getState());

        $this->stateMachine->stop();
        $this->stateMachine->boot($this->state2);
        $this->assertEquals($this->state2, $this->stateMachine->getState());
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testGetStateException()
    {
        $this->stateMachine->getState();
    }

    public function testGetAvailableStates()
    {
        $this->setupMachine1();

        $this->stateMachine->boot($this->state1);
        $this->assertEquals(array($this->state2), $this->stateMachine->getAvailableStates());
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state2);
        $this->assertEquals(array($this->state1, $this->state3), $this->stateMachine->getAvailableStates());
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state3);
        $this->assertEquals(array(), $this->stateMachine->getAvailableStates());
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testGetAvailableStatesException()
    {
        $this->setupMachine1();
        $this->stateMachine->getAvailableStates();
    }

    public function testIsCurrently()
    {
        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isCurrently($this->state1));
        $this->assertFalse($this->stateMachine->isCurrently($this->state2));
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testIsCurrentlyException()
    {
        $this->stateMachine->isCurrently($this->state1);
    }

    public function testIsAvailable()
    {
        $this->setupMachine1();

        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isAvailable($this->state2));
        $this->assertFalse($this->stateMachine->isAvailable($this->state3));
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state2);
        $this->assertTrue($this->stateMachine->isAvailable($this->state1));
        $this->assertTrue($this->stateMachine->isAvailable($this->state3));
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state3);
        $this->assertFalse($this->stateMachine->isAvailable($this->state1));
        $this->assertFalse($this->stateMachine->isAvailable($this->state3));
        $this->stateMachine->stop();
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testIsAvailableException()
    {
        $this->setupMachine1();
        $this->stateMachine->isAvailable($this->state1);
    }

    public function testGetAllEvents()
    {
        $this->setupMachine1();
        $this->stateMachine->boot($this->state1);
        $this->assertEquals(array('event1-2', 'event2-1', 'event2-3'),$this->stateMachine->getAllEvents());
    }

    public function testGetActiveEvents()
    {
        $this->setupMachine1();
        $this->stateMachine->boot($this->state1);
        $this->assertEquals(array('event1-2'),$this->stateMachine->getActiveEvents());
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state2);
        $this->assertEquals(array('event2-1','event2-3'),$this->stateMachine->getActiveEvents());
        $this->stateMachine->stop();

        $this->stateMachine->boot($this->state3);
        $this->assertEquals(array(),$this->stateMachine->getActiveEvents());
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testGetActiveEventsException()
    {
        $this->setupMachine1();
        $this->stateMachine->getActiveEvents();
    }

    public function testIsActive()
    {
        $this->setupMachine1();
        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isActive('event1-2'));
        $this->assertFalse($this->stateMachine->isActive('event2-1'));
        $this->assertFalse($this->stateMachine->isActive('event2-3'));
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testIsActiveException()
    {
        $this->setupMachine1();
        $this->stateMachine->isActive('event1-2');
    }

    public function testTrigger()
    {
        $this->setupMachine1();
        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isCurrently($this->state1));
        $this->stateMachine->trigger('event1-2');
        $this->assertTrue($this->stateMachine->isCurrently($this->state2));
        $this->stateMachine->trigger('event2-3');
        $this->assertTrue($this->stateMachine->isCurrently($this->state3));
    }

    /**
     * @expectedException \StateMachine\Exception\StateMachineUnavailableException
     */
    public function testTriggerUnavailableException()
    {
        $this->setupMachine1();
        $this->stateMachine->trigger('event1-2');
    }

    public function testBoot()
    {
        $this->assertFalse($this->stateMachine->isBooted());
        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isBooted());
    }

    /**
     * @expectedException \StateMachine\Exception\AlterStateMachineException
     */
    public function testBootException()
    {
        $this->stateMachine->boot($this->state1);
        $this->stateMachine->boot($this->state1);
    }

    public function testStop()
    {
        $this->assertFalse($this->stateMachine->isBooted());
        $this->stateMachine->boot($this->state1);
        $this->assertTrue($this->stateMachine->isBooted());
        $this->stateMachine->stop();
        $this->assertFalse($this->stateMachine->isBooted());
    }
}
 