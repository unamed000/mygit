<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers the given process to have the given exhaust rate.
 *
 * A rated exhaust allows for you to install processes that exhaust at the set 
 * rate rather than 1.
 *
 * If you require a null exhaust process use the ``null_exhaust`` function.
 *
 * @param  callable|process  $process  PHP Callable or Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Defining process exhaust.
 *
 * Defines the given process with an exhaust of 5.
 * 
 * .. code-block:: php
 *
 *    <?php
 *    
 *    signal(SIG('foo'), exhaust(5, function(){
 *        echo 'foo';
 *    });
 *
 *    for($i=0;$i<5;$i++){
 *        emit('foo');
 *    }
 *    
 *    // results
 *    // foofoofoofoofoo
 *
 * @example
 *
 * Null exhaust process.
 *
 * Install a process that never exhausts.
 *
 * .. note::
 *
 *     Once a null exhaust process is installed it must be removed using 
 *     ``delete_process``.
 *
 * .. code-block:: php
 *
 *     <?php
 *
 *     signal(SIG('foo'), null_exhaust(function(){
 *         echo "foo";
 *     }));
 *
 *     for ($i=0;$i<35;$i++) {
 *         emit(SIG('foo'));
 *     }
 *     // results
 *     // foo
 *     // foo
 *     // foo
 *     // foo
 *     // ...
 */ 
function exhaust($limit, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process, $limit);
        return $process;
    }
    $process->set_exhaust($limit);
    return $process;
}