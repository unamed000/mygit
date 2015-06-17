<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Cleans any exhausted signals from the processor.
 * 
 * @param  boolean  $history  Also erase any history of the signals cleaned.
 * 
 * @return  void
 */
function clean($history = false)
{
    return XPSPL::instance()->clean($history);
}