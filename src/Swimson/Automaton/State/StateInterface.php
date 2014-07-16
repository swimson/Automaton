<?php

namespace Swimson\Automaton\State;

interface StateInterface
{
    /**
     * Get Name
     * @return string
     */
    public function getName();

    /**
     * Add Transition
     * @param $event
     * @param StateInterface $target
     * @return $this
     */
    public function addTransition($event, StateInterface $target);

    /**
     * Returns an array of Transition objects
     * @return array
     */
    public function getTransitions();

    /**
     * Returns an array of events that are available for this state
     * @return array
     */
    public function getEvents();

    /**
     * Returns an array of events that are available from this state
     * @return array
     */
    public function getActiveEvents();
}