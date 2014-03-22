<?php

namespace StateMachine;

class Transition implements  TransitionInterface
{

    private $source;
    private $trigger;
    private $target;

    /**
     * @inheritDoc
     */
    public function __construct(StateInterface $source, EventInterface $trigger, StateInterface $target)
    {
        $this->source = $source;
        $this->trigger = $trigger;
        $this->target = $target;
    }

    /**
     * @inheritDoc
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @inheritDoc
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @inheritDoc
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

} 