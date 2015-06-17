<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

date_default_timezone_set('America/New_York');

/**
 * CRON
 *
 * This example demonstrates how to use CRON to awake XPSPL.
 */
import('time');

time\CRON('*/1 * * * *', function(){
    echo "Every Minute!".PHP_EOL;
});