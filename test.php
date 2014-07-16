<?php

include(__DIR__ . '/src/StateMachine/StateMachineInterface.php');
include(__DIR__ . '/src/StateMachine/StateInterface.php');
include(__DIR__ . '/src/StateMachine/TransitionInterface.php');
include(__DIR__ . '/src/StateMachine/State.php');
include(__DIR__ . '/src/StateMachine/StateMachine.php');
include(__DIR__ . '/src/StateMachine/Transition.php');

use StateMachine\State;
use StateMachine\StateMachine;

// States Available
$child   = new State('child');
$adult   = new State('adult');
$engaged = new State('engaged');
$married = new State('married');
$divorced = new State('divorced');
$widowed = new State('widowed');
$dead    = new State('dead');

// Transitions Available
$child->addTransition('grows-up', $adult);
$child->addTransition('death', $dead);
$adult->addTransition('engagement', $engaged);
$adult->addTransition('death', $dead);
$engaged->addTransition('wedding-canceled', $adult);
$engaged->addTransition('wedding', $married);
$engaged->addTransition('death', $dead);
$married->addTransition('divorce', $divorced);
$married->addTransition('death', $dead);
$married->addTransition('spouse-dies', $widowed);
$widowed->addTransition('engagement', $engaged);
$widowed->addTransition('death', $dead);
$divorced->addTransition('engagement', $engaged);
$divorced->addTransition('death', $dead);

// Boot up State Machine
$fsm = new StateMachine($child);
$fsm->addState($adult);
$fsm->addState($engaged);
$fsm->addState($married);
$fsm->addState($divorced);
$fsm->addState($widowed);
$fsm->addState($dead);
$fsm->boot($child);
?>

<h2>Initial State: </h2>
<?php echo $fsm->getState(); ?>

<h2>Process Event <em>grows-up</em></h2>
<?php echo $fsm->trigger('grows-up')->getState(); ?>

<h2>Process Event <em>engagement</em></h2>
<?php echo $fsm->trigger('engagement')->getState(); ?>

<h2>Wedding Canceled</h2>
<?php echo $fsm->trigger('wedding-canceled')->getState(); ?>

<h2>Try to Skip To <em>Married</em></h2>
<?php echo $fsm->trigger('wedding')->getState(); ?>

<h2>Get Engaged a Second Time and Get Married</h2>
<?php echo $fsm->trigger('engagement')->trigger('wedding')->getState(); ?>

<h2>Person Dies</h2>
<?php echo $fsm->trigger('death')->getState(); ?>

