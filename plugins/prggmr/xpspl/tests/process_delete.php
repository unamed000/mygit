<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $db = new \XPSPL\database\Processes();
    $p1 = new \XPSPL\Process(null);
    $p2 = high_priority(new \XPSPL\Process(null));
    $db->install($p1);
    $db->install($p2);
    $db->delete($p1);
    $test->equal($db->count(), 1);
    $test->equal($db->current()->get_priority(), 0);
}, "process delete");