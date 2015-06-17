<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once dirname(realpath(__FILE__)).'/../__init__.php';

import('unittest');

unittest\test(function($test){
    $foo = SIG('foo');
    signal($foo, null);
    $test->instanceof(find_signal_database($foo), 'XPSPL\database\Processes');
});