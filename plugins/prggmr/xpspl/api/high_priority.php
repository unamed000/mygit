<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have a high priority.
 *
 * Processes registered with a high priority will be executed before those with 
 * a low or default priority.
 *
 * This allows for controlling the order of processes rather than using FIFO.
 *
 * A high priority process is useful when multiple processes will execute and it 
 * must always be one of the very first to run.
 *
 * This registers the priority as *0*.
 *
 * .. note::
 *
 *    This is not an interruption.
 *    
 *    Installed interruptions will still be executed before a high priority 
 *    process.
 *
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Install a process with high priority
 *
 * High priority process will always execute first.
 *
 * .. code-block:: php
 * 
 *    <?php
 *    
 *    signal('foo', function(){
 *        echo 'bar';
 *    });
 *    
 *    signal('foo', high_priority(function(){
 *        echo 'foo';
 *    }));
 *
 *    // results when foo is emitted
 *    // foobar
 */
function high_priority($process)
{
    return priority(0, $process);
}