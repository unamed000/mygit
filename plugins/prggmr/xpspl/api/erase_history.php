<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Cleans out the entire signal history.
 *
 * @return  void
 */
function erase_history()
{
    return XPSPL::instance()->erase_history();
}