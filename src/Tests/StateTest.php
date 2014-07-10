<?php

namespace Tests;

use StateMachine\State;
use Mockery as m;

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
        $transition = m::mock('StateMachine\Transition', array($state1, 'woot', $state2));
        $state1->addTransition('event1', $transition);
        $this->assertEquals(array('event1' => $transition), $state1->getTransitions());
    }
}
