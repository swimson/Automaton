<?php

namespace StateMachine\Exception;

class AlterStateMachineException extends \Exception
{
    const MSG = 'Unable to alter StateMachine after machine has been booted.  To make changes, turn StateMachine off.';

    public function __toString()
    {
        return self::MSG;
    }
}
