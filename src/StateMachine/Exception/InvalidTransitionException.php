<?php

namespace StateMachine\Exception;

class InvalidTransitionException extends \Exception
{
    const MSG = 'This is an invalid transition for this State.';

    public function __toString()
    {
        return self::MSG;
    }
}
 