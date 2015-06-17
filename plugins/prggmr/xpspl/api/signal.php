<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Installs a new process to execute when the given signal is emitted.
 *
 * .. note::
 * 
 *    All processes unless otherwise specified have a default exhaust of ``XPSPL_EXHAUST_DEFAULT``.
 *
 * .. note::
 *
 *    Processes installed to the same signal execute in FIFO order without priority.
 *
 * @param  object  $signal  Signal to install process on.
 * @param  object  $callable  PHP Callable
 *
 * @return  object | boolean - \XPSPL\Process otherwise boolean on error
 *
 * Beginning in XPSPL v4.0.0 all signals were converted to strictly objects.
 *
 * To use a string or integer as a signal it must be wrapped in a ``SIG``.
 *
 * .. note::
 *
 *    Any signals wrapped in SIG cannot be unique.
 *
 * @example
 *
 * Install a new process.
 *
 * This demonstrates installing a new process to execute on ``SIG(foo)``.
 *
 * .. code-block:: php
 *
 *     <?php
 *     signal(SIG('foo'), function(){
 *         echo "foo was emitted";
 *     });
 *
 *     emit('foo');
 *
 * **Results**
 *
 * .. code-block:: text
 *     
 *     foo was emitted
 *
 * @example
 *
 * String or Integer signals
 *
 * When using strings or integers as a signal the string or integer must be 
 * wrapped in the ``SIG`` function.
 *
 * .. code-block:: php
 * 
 *     <?php
 *     // install a process for foo
 *     signal('foo', function(){
 *         echo 'foo';
 *     });
 *     // emit foo
 *     emit('foo');
 *     // results
 *     // foo
 */
function signal(\XPSPL\SIG $signal, $process)
{
    if (!$process instanceof \XPSPL\Process) {
        $process = new \XPSPL\Process($process);
    }
    return XPSPL::instance()->signal($signal, $process);
}