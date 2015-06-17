<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Awake
 *
 * This example demonstrates how to awake XPSPL.
 */
import('time');

time\awake(10, function(){
    echo "10 Seconds just passed!".PHP_EOL;
});

time\awake(5, null_exhaust(function(){
    echo "Every 5 seconds".PHP_EOLz;
}));