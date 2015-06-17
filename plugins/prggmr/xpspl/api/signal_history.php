<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Returns the current signal history.
 *
 * The returned history is stored in an array using the following indexes.
 *
 * .. code-block:: php
 *
 *    <?php
 *    $array = [
 *        0 => Signal Object
 *        1 => Time in microseconds since Epoch at emittion
 *    ];
 *    
 * @return  array
 *
 * @example
 *
 * Counting emitted signals
 *
 * This counts the number of ``SIG('foo')`` signals that were emitted.
 *
 * .. code-block:: php
 *
 *    <?php
 *    $sig = SIG('foo');
 *    // Emit a few foo objects
 *    for($i=0;$i<5;$i++){
 *        emit($sig);
 *    }
 *    $emitted = 0;
 *    foreach(signal_history() as $_node) {
 *        if ($_node[0] instanceof $sig) {
 *            $emitted++;
 *        }
 *    }
 *    echo $emitted;
 */
function signal_history(/* ... */)
{
    return XPSPL::instance()->signal_history();
}