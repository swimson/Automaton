<?php

namespace StateMachine;

class StateMachine implements StateMachineInterface
{

    const STATE_INITIAL      = 0;
    const STATE_INTERMEDIATE = 1;
    const STATE_FINAL        = 2;

    /**
     * @var array
     */
    private $states;

    /**
     * @var StateInterface
     */
    private $currentState;


    public function __construct(StateInterface $start)
    {
        $this->currentState = $start;
        $this->priorState   = $start;
    }

    /**
     * @inheritDoc
     */
    public function addState(StateInterface $state)
    {
        $this->states[$state->getName()] = $state;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeState(StateInterface $state)
    {
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
    public function boot()
    {
        // TODO: Implement boot() method.
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function is(StateInterface $state)
    {
        return $this->currentState->getName() == $state->getName();
    }

    /**
     * @inheritDoc
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @inheritDoc
     */
    public function process($event)
    {
        if ($this->can($event)) {
            $transitions = $this->currentState->getTransitions();
            $targetState = $transitions[$event]->getTarget();
            $this->transitionTo($targetState);
        }

        return $this;
    }

    private function transitionTo(StateInterface $targetState)
    {
        if ($this->currentState->getName() != $targetState->getName()) {
            $this->priorState   = $this->currentState;
            $this->currentState = $targetState;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAvailableStates()
    {
        $transitions = $this->currentState->getTransitions();

        $return = array();
        foreach ($transitions as $transition) {
            $targetName = $transition->getTarget()->getName();
            if (!array_key_exists($targetName, $return)) {
                $return[] = $transition->getTarget()->getName();
            }
        }

        return $return;
    }


    /**
     * @inheritDoc
     */
    public function can($event)
    {
        $return      = false;
        $transitions = $this->currentState->getTransitions();
        foreach ($transitions as $transition) {
            if ($event == $transition->getEvent() ){
                $return = true;
            }
        }
        return $return;
    }

    /**
     * @inheritDoc
     */
    public function canTransitionTo(StateInterface $state)
    {
        $return      = false;
        $transitions = $this->currentState->getTransitions();
        foreach ($transitions as $transition) {
            if ($state->getName() == $transition->getTarget()->getName()) {
                $return = true;
            }
        }

        return $return;
    }


} 