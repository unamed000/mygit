<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Sends the loop the shutdown signal.
 *
 * @return  void
 */
function shutdown()
{
    return XPSPL::instance()->shutdown();
}