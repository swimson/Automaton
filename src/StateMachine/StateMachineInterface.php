<?php

namespace StateMachine;

interface StateMachineInterface{

    public function __construct(StateInterface $start);

    /**
     * Add a state to the Machine
     * @param StateInterface $state
     * @return StateMachine
     */
    public function addState(StateInterface $state);

    /**
     * Removes a state from the Machine
     * @param StateInterface $state
     * @return StateMachine
     */
    public function removeState(StateInterface $state);

    /**
     * Returns the current state
     * @return State
     */
    public function getCurrentState();

    /**
     * Gets the available target states
     * @return array
     */
    public function getAvailableStates();

    /**
     * Get all the states loaded into the machine
     * @return array
     */
    public function getAllStates();

    /**
     * Boots the finite state machine
     * @return StateMachine
     */
    public function boot();

    /**
     * Triggers an Event within the Machine
     * @param string $event
     * @return StateMachine
     */
    public function process( $event);

    /**
     * Can an event be triggered within the Machine
     * @param string $event
     * @return bool
     */
    public function can($event);

    /**
     * Checks if the Machine is in a given state
     * @param StateInterface $state
     * @return bool
     */
    public function is(StateInterface $state);

    /**
     * Returns whether the state is available to transition to
     * @param StateInterface $state
     * @return bool
     */
    public function canTransitionTo(StateInterface $state);
}