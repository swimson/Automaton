<?php

namespace StateMachine;

include('/var/www/StateMachineInterface.php');
include('/var/www/StateInterface.php');
include('/var/www/TransitionInterface.php');
include('/var/www/State.php');
include('/var/www/StateMachine.php');
include('/var/www/Transition.php');

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
$fsm->boot();
?>



<h2>Initial State: </h2>
<?php echo $fsm->getCurrentState(); ?>

<h2>Available States</h2>
<?php print_r($fsm->getAvailableStates()); ?>

<h2>Process Event <em>grows-up</em></h2>
<?php echo $fsm->process('grows-up')->getCurrentState(); ?>

<h2>Process Event <em>engagement</em></h2>
<?php echo $fsm->process('engagement')->getCurrentState(); ?>

<h2>Undo Engagement</h2>
<?php echo $fsm->undo()->getCurrentState(); ?>

<h2>Try to Skip To Married</h2>
<?php echo $fsm->process('wedding')->getCurrentState(); ?>

<h2>Get Engaged a Second Time and Get Married</h2>
<?php echo $fsm->process('engagement')->process('wedding')->getCurrentState(); ?>

<h2>Unable to Undo Marriage</h2>
<?php echo $fsm->undo()->getCurrentState(); ?>

<h2>Person Dies</h2>
<?php echo $fsm->process('death')->getCurrentState(); ?>

