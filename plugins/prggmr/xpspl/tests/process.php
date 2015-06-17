<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $process = new XPSPL\Process(null);
    $test->equal($process->exhaustion(), XPSPL_PROCESS_DEFAULT_EXHAUST);
    $test->equal($process->get_priority(), XPSPL_PROCESS_DEFAULT_PRIORITY);
}, "process construction");

unittest\test(function($test){
    $process = new XPSPL\Process(function(){});
    $test->false($process->is_exhausted());
    $process->decrement_exhaust();
    $test->true($process->is_exhausted());
    $process = new XPSPL\Process(function(){}, 2);
    $process->decrement_exhaust();
    $test->false($process->is_exhausted());
    $process->decrement_exhaust();
    $test->true($process->is_exhausted());
    $process = new XPSPL\Process(function(){}, null);
    for ($i=0;$i!=5;$i++) { $process->decrement_exhaust(); }
    $test->false($process->is_exhausted());
    $process = new XPSPL\Process(function(){}, 0);
    $test->true($process->is_exhausted());
}, "Process exhaustion");

unittest\test(function($test){
    $process = new XPSPL\Process(function(){});
    $process->set_priority(100);
    $test->equal(100, $process->get_priority());
    $process->set_priority('a');
    $test->equal($process->get_priority(), XPSPL_PROCESS_DEFAULT_PRIORITY);
}, "Process Priority");