<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Call the provided function on processor start.
 * 
 * @param  callable|object  $function  Function or process object
 * 
 * @return  object  \XPSPL\Process
 */
function on_start($function)
{
    return signal(new \XPSPL\processor\SIG_Startup(), $function);
}