<?php

namespace StateMachine;

interface StateInterface
{
    /**
     * Get Name
     * @return string
     */
    public function getName();

    /**
     * Add Transition
     * @param TransitionInterface $transition
     * @throws \StateMachine\Exception\InvalidTransitionException
     * @return null
     */
    public function addTransition(TransitionInterface $transition);

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