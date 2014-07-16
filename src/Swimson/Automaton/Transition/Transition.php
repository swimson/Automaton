<?php

namespace Swimson\Automaton\Transition;

use Swimson\Automaton\State\StateInterface;

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
     * @inheritDoc
     */
    public function __construct(StateInterface $source, $event, StateInterface $target)
    {
        $this->source = $source;
        $this->event  = $event;
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
    public function getEvent()
    {
        return $this->event;
    }
}