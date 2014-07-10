<?php

namespace StateMachine;

interface StateMachineInterface
{
    const STATE_MACHINE_OFF    = 0;
    const STATE_MACHINE_BOOTED = 1;

    /**************************************************************
     * Initialization
     **************************************************************/

    /**
     * Add a state to the Machine
     * @param StateInterface $state
     * @return StateMachine
     * @throws \StateMachine\Exception\AlterStateMachineException
     */
    public function addState(StateInterface $state);

    /**
     * Removes a state from the Machine
     * @param StateInterface $state
     * @return StateMachine
     * @throws \StateMachine\Exception\AlterStateMachineException
     */
    public function removeState(StateInterface $state);

    /**
     * Get all the states loaded into the machine
     * @return array
     */
    public function getAllStates();


    /**************************************************************
     * Based on Current State
     **************************************************************/

    /**
     * Returns the current state
     * @return State
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function getState();

    /**
     * Gets the available target states
     * @return array
     */
    public function getAvailableStates();

    /**
     * Checks if the Machine is in a given state
     * @param StateInterface $state
     * @return bool
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function isCurrently(StateInterface $state);

    /**
     * Returns whether the state is available to transition to
     * @param StateInterface $state
     * @return bool
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function isAvailable(StateInterface $state);

    /**************************************************************
     * Events
     **************************************************************/

    /**
     * Get all possible events
     * @return array
     */
    public function getAllEvents();

    /**
     * Get the list of active event - those that will trigger a state change
     * @return array
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function getActiveEvents();

    /**
     * Will the event trigger a state change?
     * @param string $event
     * @return boolean
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function isActive($event);

    /**
     * Triggers an Event within the Machine
     * @param string $event
     * @return StateMachine
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function trigger($event);


    /**************************************************************
     * StateMachine Boot
     **************************************************************/

    /**
     * Boots the finite state machine
     * @param StateInterface $startingState
     * @return StateMachine
     * @throws \StateMachine\Exception\StateMachineUnavailableException
     */
    public function boot(StateInterface $startingState);

    /**
     * Turns off the finite state machine
     * @return StateMachine
     */
    public function stop();

    /**
     * Returns whether the state machine is booted
     * @return boolean
     */
    public function isBooted();
}