<?php

namespace StateMachine;

interface TransitionInterface
{

    /**
     * Constructor
     * @param StateInterface $source
     * @param EventInterface $trigger
     * @param StateInterface $target
     */
    public function __construct(StateInterface $source, EventInterface $trigger, StateInterface $target);

    /**
     * Get Source State
     * @return State
     */
    public function getSource();

    /**
     * Get Trigger Event
     * @return Event
     */
    public function getTrigger();

    /**
     * Get Target State
     * @return State
     */
    public function getTarget();

}