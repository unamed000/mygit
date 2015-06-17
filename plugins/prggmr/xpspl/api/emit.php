<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Emit a signal. 
 * 
 * This will execute all processes and interruptions installed to the signal. 
 * 
 * The executed ``SIG`` object is returned.
 *
 * .. note::
 *
 *    When emitting unique signals, e.g.. complex, routines or defined uniques 
 *    the unique sig object installed must be given.
 *
 * Once a signal is emitted the following execution chain takes place.
 *
 * 1. Before process interruptions
 * 2. Installed processes
 * 3. After process interruptions
 *
 * @param  signal  $signal  Signal to emit.
 * @param  object  $context  Signal context.
 *
 * @return  object  SIG
 *
 * @example
 *
 * Emitting a unique signal
 *
 * When a unique signal is emitted
 *
 * .. code-block:: php
 *
 *    <?php
 *    // Create a unique Foo signal.
 *    class Foo extends \XPSPL\SIG {
 *        // declare it as unique
 *        protected $_unique = true;
 *    }
 *    // Install a null exhaust process for the Foo signal
 *    $foo = new Foo();
 *    signal($foo, null_exhaust(function(){
 *        echo "Foo";
 *    }));
 *    // Emit foo and new Foo
 *    emit($foo);
 *    emit(new Foo());
 *    // Results
 *    // Foo
 */
function emit($signal, $context = null)
{
    if (!$signal instanceof \XPSPL\SIG) {
        $signal = new \XPSPL\SIG($signal);
    }
    return XPSPL::instance()->emit($signal, $context);
}