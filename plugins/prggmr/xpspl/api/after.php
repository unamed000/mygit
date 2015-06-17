<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs the given process to interrupt the signal ``$signal`` when emitted.
 *
 * Interruption processes installed using this function interrupt directly 
 * after a signal is emitted.
 *
 * .. warning:: 
 *
 *    Interruptions are not a fix for improperly executing process priorities 
 *    within a signal.
 *    
 *    If unexpected process priority are being executed debug them... 
 *
 * .. note::
 *
 *    Interruptions use the same prioritizing as the Processor.
 *    
 * @param  callable|process  $process  PHP Callable or \XPSPL\Process.
 *
 * @return  object  Process
 *
 * @example
 *
 * Install a interrupt process after foo
 *
 * High priority process will always execute first immediatly following 
 * interruptions.
 *
 * .. code-block:: php
 * 
 *    <?php
 *    
 *    signal(SIG('foo'), function(){
 *        echo 'foo';
 *    });
 *
 *    after(SIG('foo'), function(){
 *        echo 'after foo';
 *    });
 *
 *    // results when foo is emitted
 *    // fooafter foo
 *
 * @example
 *
 * After Interrupt Process Priority
 *
 * Install after interrupt processes with priority.
 *
 * .. code-block:: php
 *
 *    <?php
 *    signal(SIG('foo'), function(){
 *        echo 'foo';
 *    })
 *    
 *    after(SIG('foo'), low_priority(function(){
 *        echo 'low priority foo';
 *    }));
 *    
 *    after(SIG('foo'), high_priority(function(){
 *        echo 'high priority foo';
 *    }));
 *    
 *    emit(SIG('foo'));
 *
 *    // results
 *    // foo highpriorityfoo lowpriorityfoo
 */
function after($signal, $process)
{
    if (!$signal instanceof \XPSPL\SIG) {
        $signal = new \XPSPL\SIG($signal);
    }
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->after($signal, $process);
}