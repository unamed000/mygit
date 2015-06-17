<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Removes an installed signal process.
 *
 * @param  string|integer|object  $signal  Signal process is attached to.
 * @param  object  $process  Process.
 *
 * @return  void
 *
 * @example
 *
 * Removing installed processes
 *
 * Removes the installed process from the foo signal.
 *
 * .. code-block::php
 *
 *    <?php
 *    $process = signal('foo', function(){});
 *    
 *    delete_process('foo', $process);
 */
function delete_process($signal, $process)
{
    return XPSPL::instance()->delete_process($signal, $process);   
}