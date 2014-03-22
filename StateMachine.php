<?php

namespace StateMachine;


class StateMachine implements StateMachineInterface
{

    private $start;
    private $states = array();
    private $targets = array();

    public function __construct(StateInterface $start){
        $this->start = $start;
    }

    public function getStates()
    {
        // TODO: Implement getStates() method.
    }

    public function getAllTargets()
    {
        // TODO: Implement getAllTargets() method.
    }


} 