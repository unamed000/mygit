<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Generates an XPSPL SIG object from the given ``$signal``.
 *
 * This function is only a shorthand for ``new SIG($signal)``.
 *
 * @param  string|  $signal  Signal process is attached to.
 * 
 * @return  object  \XPSPL\SIG
 *
 * @example
 *
 * Creating a SIG.
 *
 * This will create a SIG idenitified by 'foo'.
 *
 * .. code-block:: php
 *
 *    <?php
 *    signal(SIG('foo'), function(){
 *        echo "HelloWorld";
 *    });
 *    
 *    emit(SIG('foo'));
 */
function SIG($signal)
{
    return new \XPSPL\SIG($signal);
}