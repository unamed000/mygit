<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\test(function($test){
    $db_1 = new \XPSPL\database\Processes();
    $db_2 = new \XPSPL\database\Processes();
    $count = 0;
    for ($i=0;$i<1000;$i++) {
        $db_1->install(new \XPSPL\Process(null));
        $db_2->install(new \XPSPL\Process(null, null));
    }
    $test->instanceof($db_1->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 'XPSPL\database\Processes');
    logger(XPSPL_LOG)->info($db_1->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY)->count());
    $test->count($db_1->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 1000);
    $test->instanceof($db_2->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 'XPSPL\database\Processes');
    $test->count($db_2->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY), 1000);
    $org_db = clone $db_1;
    $db_1->merge($db_2);
    $test->equal(
        $db_1->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY)->rewind(), 
        $org_db->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY)->rewind()
    );
    $test->equal(
        $db_1->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY)->end(),
        $db_2->offsetGet(XPSPL_PROCESS_DEFAULT_PRIORITY)->end()
    );
});