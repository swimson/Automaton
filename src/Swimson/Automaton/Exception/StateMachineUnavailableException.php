<?php

namespace Swimson\Automaton\Exception;

class StateMachineUnavailableException extends \Exception
{
    const MSG = 'Unable to access StateMachine before machine has been booted.';

    public function __toString()
    {
        return self::MSG;
    }
}
