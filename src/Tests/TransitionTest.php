<?php

namespace Tests;

use StateMachine\State;
use StateMachine\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
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
    protected $transition;

    public function setup()
    {
        $this->state1     = new State('state1');
        $this->state2     = new State('state2');
        $this->transition = new Transition($this->state1, 'event', $this->state2);
    }

    public function testInterface()
    {
        $this->assertInstanceOf('StateMachine\TransitionInterface', $this->transition);
    }

    public function testGetSource()
    {
        $this->assertInstanceOf('StateMachine\StateInterface', $this->transition->getSource());
        $this->assertEquals($this->state1, $this->transition->getSource());
    }

    public function testGetTarget()
    {
        $this->assertInstanceOf('StateMachine\StateInterface', $this->transition->getTarget());
        $this->assertEquals($this->state2, $this->transition->getTarget());
    }
}
