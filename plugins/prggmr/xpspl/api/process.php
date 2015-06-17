<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Creates a new XPSPL Process object.
 *
 * .. note::
 *    
 *    See the ``priority`` and ``exhaust`` functions for setting the priority 
 *    and exhaust of the created process.
 *
 * @param  callable  $callable
 *
 * @return  void
 *
 * @example
 *
 * Creates a new XPSPL Process object.
 *
 * .. code-block::php
 *
 *    <?php
 *    
 *    $process = process(function(){});
 *
 *    signal(SIG('foo'), $process);
 *    
 */
function process($callable)
{
    return new \XPSPL\Process($callable);
}