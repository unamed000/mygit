<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

// tmp class for state test
class XPSPL_TEST_State {
    use XPSPL\State;
}

unittest\test(function($test){
    $state = new XPSPL_TEST_State();
    $test->equal($state->get_state(), STATE_DECLARED);
    $state->set_state(STATE_RUNNING);
    $test->equal($state->get_state(), STATE_RUNNING);
}, 'Test state');