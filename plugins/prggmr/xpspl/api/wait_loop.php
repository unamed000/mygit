<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Starts the XPSPL wait loop.
 *
 * @return  void
 */
function wait_loop()
{
    return XPSPL::instance()->wait_loop();
}