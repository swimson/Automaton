<?php

namespace StateMachine;

interface StateInterface
{
    /**
     * Constructor
     * @param string $name
     */
    public function __construct($name);

    /**
     * Get Name
     * @return string
     */
    public function getName();

    /**
     * Add Transition
     * @param EventInterface $event
     * @param StateInterface $targetState
     * @return null
     */
    public function addTransition(EventInterface $event, StateInterface $targetState);
}