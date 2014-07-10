<?php

namespace StateMachine;

interface TransitionInterface
{

    /**
     * Constructor
     * @param StateInterface $source
     * @param string $event
     * @param StateInterface $target
     * @param bool $reversible
     */
    public function __construct(StateInterface $source, $event, StateInterface $target, $reversible = true);

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
}