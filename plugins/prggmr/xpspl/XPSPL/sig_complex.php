<?php
namespace XPSPL;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \LogicException,
    \XPSPL\Routine;

/**
 * SIG_Complex
 * 
 * @since v0.3.0
 * 
 * SIG_Complex evaluates the emitting signal to provide the processor 
 * information for.
 *
 * - Signals to emit
 */
abstract class SIG_Complex extends SIG {

    protected $_unique = true;

    /**
     * Evaluates the emitted signal.
     *
     * @param  string|integer  $signal  Signal to evaluate
     *
     * @return  boolean|object  False|XPSPL\Evaluation
     */
    abstract public function evaluate($signal = null);
}