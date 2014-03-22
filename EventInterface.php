<?php

namespace StateMachine;

interface EventInterface
{
    /**
     * Constructor
     * @param string $code
     * @param string $name
     */
    public function __construct($code, $name);

    /**
     * Get Name
     * @return string
     */
    public function getName();

    /**
     * Get Code
     * @return string
     */
    public function getCode();
}
