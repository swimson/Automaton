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

        $state1->addTransition('event1', $state2);
        $this->assertEquals(1, count($state1->getTransitions()));
    }
}
