<?php

namespace StateMachine;

class Transition implements TransitionInterface
{

    /**
     * @var StateInterface
     */
    private $source;

    /**
     * @var string
     */
    private $event;

    /**
     * @var StateInterface
     */
    private $target;

    /**
     * @var bool
     */
    private $reversible;

    /**
     * @inheritDoc
     */
    public function __construct(StateInterface $source, $event, StateInterface $target, $reversible = true)
    {
        $this->source = $source;
        $this->event = $event;
        $this->target = $target;
        $this->reversible = true;
    }

    function __toString()
    {
        return $this->getName();
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
    public function getEvent()
    {
        return $this->event;
    }
}