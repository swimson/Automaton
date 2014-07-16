<?php

namespace Swimson\Automaton\Transition;

interface TransitionInterface
{
    /**
     * Get Source State
     * @return \Swimson\Automaton\State\State
     */
    public function getSource();


    /**
     * Get Target State
     * @return \Swimson\Automaton\State\
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getEvent();
}