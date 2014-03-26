<?php

namespace StateMachine;

class State implements StateInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $transitions = array();

    /**
     * @inheritDoc
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    function __toString()
    {
        return $this->getName();
    }

    /**
     * @inheritDoc
     */
    public function addTransition($event, StateInterface $targetState)
    {
        $this->transitions[$event] = new Transition($this, $event, $targetState);
    }

    /**
     * @inheritDoc
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }
} 