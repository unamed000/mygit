<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

import('unittest');

use XPSPL\idle\Time;

unittest\suite(function($suite){

    $suite->test(function($test){
        $time1 = new Time(1, TIME_SECONDS);
        $time2 = new Time(1500, TIME_MILLISECONDS);
        $test->true($time1->override($time2));
    }, 'Milliseconds more than seconds');

    $suite->test(function($test){
        $time1 = new Time(2, TIME_SECONDS);
        $time2 = new Time(1500, TIME_MILLISECONDS);
        $test->true($time1->override($time2));
    }, 'Seconds more than milliseconds');

});