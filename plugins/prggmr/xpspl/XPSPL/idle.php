<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Idle
 *
 * @version 1.0.0
 * 
 * The idle class is used for idling the processor, the base provides no 
 * functionality in itself and must be extended.
 *
 * What it does provide is a base for writing an idle object, with this it
 * gives the default functions of setting the maximum of itself allowed per 
 * loop, the priority of the idling function and allow override of the same
 * idle.
 *
 * The base provides the rules that only one type of the given idle function
 * should exist and a default priority of zero for all.
 */
abstract class Idle {

    /**
     * Priority of this idle function. Zero comes first
     *
     * @var  integer
     */
    protected $_priority = null;

    /**
     * Allow override of this function.
     *
     * When set to true the "override" method will be called otherwise the 
     * processor will signal a Idle_Function_Overflow.
     *
     * @var  boolean
     */
    protected $_allow_override = false;

    /**
     * Idle's the processor.
     *
     * This function is purely responsible for providing the processor the ability
     * to idle.
     *
     * This method is provided an instance of the processor which is wishing to 
     * idle and should respect the processors current specifications for the amount
     * of time that it needs to idle if it knows.
     *
     * You have been warned ...
     *
     * Creating a function that does not properly idle, does not respect the
     * processor specs or is poorly designed will result in terrible performance, 
     * unexpected results and can be damaging to your system ... use caution.
     * 
     * @param  object  $processor  \XPSPL\Processor
     *
     * @return  void
     */
    public function idle(\XPSPL\Processor $processor)
    {
        throw new \BadMethodCallException(sprintf(
            "Idle function for %s has not been implemented"
        ), get_class($this));
    }

    /**
     * Returns the priority of this idle function.
     *
     * @return  integer
     */
    final public function get_priority(/* ... */)
    {
        return $this->_priority;
    }

    /**
     * Return if this function allows itself to be overwritten in the limit
     * is met or exceeded.
     *
     * @return  boolean
     */
    final public function allow_override(/* ... */)
    {
        return $this->_allow_override;
    }

    /**
     * Returns if the given function can override this in the processor.
     *
     * @param  object  $idle  Idle function object
     *
     * @return  boolean
     */
    public function override($idle)
    {
        return false;
    }
}