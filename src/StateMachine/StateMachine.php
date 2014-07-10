<?php

namespace StateMachine;

use StateMachine\Exception\AlterStateMachineException;
use StateMachine\Exception\StateMachineUnavailableException;

class StateMachine implements StateMachineInterface
{

    /**
     * @var array
     */
    private $states = array();

    /**
     * @var StateInterface
     */
    private $currentState;

    /**
     * @var int
     */
    private $machineStatus;


    public function __construct()
    {
        $this->machineStatus = self::STATE_MACHINE_OFF;
    }

    /**
     * @inheritDoc
     */
    public function addState(StateInterface $state)
    {

        if($this->isBooted()){
            throw new AlterStateMachineException();
        }

        $this->states[$state->getName()] = $state;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeState(StateInterface $state)
    {
        if($this->isBooted()){
            throw new AlterStateMachineException();
        }

        if (array_key_exists($state->getName(), $this->states)) {
            unset($this->states[$state->getName()]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAllStates()
    {
        return $this->states;
    }

    /**
     * @inheritDoc
     */
    public function getState()
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        return $this->currentState;
    }

    /**
     * @inheritDoc
     */
    public function getAvailableStates()
    {
        $return = array();

        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        foreach ($this->currentState->getTransitions() as $transition) {

            /** @var Transition $transition */
            $targetName = $transition->getTarget()->getName();

            if (!array_key_exists($targetName, $return)) {
                $return[] = $transition->getTarget();
            }
        }


        return $return;
    }

    /**
     * @inheritDoc
     */
    public function isCurrently(StateInterface $state)
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        return $this->currentState->getName() == $state->getName();
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(StateInterface $state)
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        $return      = false;
        $transitions = $this->currentState->getTransitions();
        foreach ($transitions as $transition) {

            /** @var Transition $transition */
            if ($state->getName() == $transition->getTarget()->getName()) {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function getAllEvents()
    {
        $return = array();
        foreach ($this->states as $state) {

            /** @var State $state */
            $events = $state->getEvents();
            foreach ($events as $event) {
                if (!in_array($event, $return)) {
                    $return[] = $event;
                }
            }
        }

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function getActiveEvents()
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        return $this->currentState->getActiveEvents();
    }

    /**
     * @inheritDoc
     */
    public function isActive($event)
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        return in_array($event, $this->getActiveEvents());
    }

    /**
     * @inheritDoc
     */
    public function trigger($event)
    {
        if(!$this->isBooted()){
            throw new StateMachineUnavailableException();
        }

        if ($this->isActive($event)) {
            $transitions = $this->currentState->getTransitions();

            /** @var Transition $transition */
            $transition  = $transitions[$event];
            $targetState = $transition->getTarget();
            $this->transitionTo($targetState);
        }

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function boot(StateInterface $startingState)
    {
        if ($this->machineStatus == self::STATE_MACHINE_BOOTED) {
            throw new AlterStateMachineException();
        }
        $this->currentState = $startingState;
        $this->machineStatus = self::STATE_MACHINE_BOOTED;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function stop()
    {
        $this->currentState = null;
        $this->machineStatus = self::STATE_MACHINE_OFF;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isBooted()
    {
        return $this->machineStatus == self::STATE_MACHINE_BOOTED;
    }


    private function transitionTo(StateInterface $targetState)
    {
        if ($this->currentState->getName() != $targetState->getName()) {
            $this->currentState = $targetState;
        }
    }
}