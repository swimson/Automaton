<?php

namespace StateMachine;

interface TransitionInterface
{
    /**
     * Get Source State
     * @return State
     */
    public function getSource();


    /**
     * Get Target State
     * @return State
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getEvent();
}