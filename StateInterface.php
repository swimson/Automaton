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
     * @param string $event
     * @param StateInterface $targetState
     * @return null
     */
    public function addTransition($event, StateInterface $targetState);

    /**
     * Returns an array of Transition objects
     * @return array
     */
    public function getTransitions();
}