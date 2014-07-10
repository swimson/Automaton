<?php

namespace StateMachine\Tests;

use StateMachine\State;
use StateMachine\Transition;

class StateTest extends \PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf('StateMachine\StateInterface', new State('test'));
    }

    public function testGetName()
    {
        $state = new State('test');
        $this->assertEquals('test', $state->getName());
    }

    public function testAddTransition()
    {
        $state1 = new State('test1');
        $state2 = new State('test2');

        $transition = new Transition($state1, 'event1', $state2);
        $state1->addTransition($transition);
        $this->assertEquals(array('event1' => $transition), $state1->getTransitions());
    }

    /**
     * @expectedException \StateMachine\Exception\InvalidTransitionException
     */
    public function testAddTransitionException()
    {
        $state1 = new State('test1');
        $state2 = new State('test2');

        $transition = new Transition($state1, 'event1', $state2);
        $state2->addTransition($transition);
    }
}
