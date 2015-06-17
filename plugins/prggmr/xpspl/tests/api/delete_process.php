<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once dirname(realpath(__FILE__)).'/../__init__.php';

import('unittest');

/**
 * Emit Unitest
 */
unittest\test(function($test){
    $foo = SIG('foo');
    $process = process(null);
    signal($foo, $process);
    delete_process($foo, $process);
    emit($foo);
    $test->exception('LogicException', function() use ($foo){
        echo $foo->foo;
    });
});