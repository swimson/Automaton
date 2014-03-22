<?php

namespace StateMachine;

interface StateMachineInterface{

    public function __construct(StateInterface $start);
    public function getStates();
    public function getAllTargets();
    public function addState();
    public function addTransition();
    public function addEvent();
}