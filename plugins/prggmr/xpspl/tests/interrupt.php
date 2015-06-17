<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $foo = SIG('foo');
    before($foo, function($foo){
        $foo->bar = 'HelloWorld';
    });
    after($foo, function($foo){
        unset($foo->bar);
    });
    signal($foo, function($foo) use ($test) {
        $test->equal($foo->bar, 'HelloWorld');
    });
    emit($foo);
    $test->false(isset($foo->bar));
}, 'Interruptions');