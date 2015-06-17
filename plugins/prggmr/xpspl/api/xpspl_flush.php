<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Empties the storage, history and clears the current state.
 *
 * @return void
 */
function XPSPL_flush(/* ... */)
{
    return XPSPL::instance()->flush();
}