<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Registers a signal in the processor.
 * 
 * @param  string|integer|object  $signal  Signal
 *
 * @return  object  Database
 */
function register_signal($signal)
{
    return XPSPL::instance()->register_signal($signal);
}