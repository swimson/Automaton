<?php

namespace Swimson\Automaton\Tests;

use Swimson\Automaton\State\State;
use Swimson\Automaton\Transition\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var State
     */
    protected $state1;

    /**
     * @var State
     */
    protected $state2;

    /**
     * @var Transition
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
        $this->assertInstanceOf('Swimson\Automaton\Transition\TransitionInterface', $this->transition);
    }

    public function testGetSource()
    {
        $this->assertInstanceOf('Swimson\Automaton\State\StateInterface', $this->transition->getSource());
        $this->assertEquals($this->state1, $this->transition->getSource());
    }

    public function testGetTarget()
    {
        $this->assertInstanceOf('Swimson\Automaton\State\StateInterface', $this->transition->getTarget());
        $this->assertEquals($this->state2, $this->transition->getTarget());
    }
}
