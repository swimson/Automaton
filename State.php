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

    /**
     * @inheritDoc
     */
    public function addTransition(EventInterface $event, StateInterface $targetState)
    {
        if($targetState){
            $this->transitions[$event->getCode()] = new Transition($this, $event, $targetState);
        }
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }


} 