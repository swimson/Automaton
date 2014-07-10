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
    public function addTransition($event, TransitionInterface $transition)
    {
        $this->transitions[$event] = $transition;
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

    /**
     * @inheritDoc
     */
    public function getEvents()
    {
        $return      = array();
        $transitions = $this->getTransitions();

        foreach ($transitions as $transition) {

            /** @var $transition Transition */
            $event = $transition->getEvent();
            if (!in_array($event, $return)) {
                $return[] = $event;
            }
        }

        return $return;
    }
} 