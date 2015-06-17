<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

require_once '__init__.php';

import('unittest');

unittest\suite(function($suite){

    $suite->setup(function($test){
        $test->processor = new XPSPL\Processor(true, true);
    });

    $suite->teardown(function($test){
        unset($test->processor);
    });

    $suite->test(function($test){
        $test->equal($test->processor->get_state(), STATE_DECLARED);
    }, 'Processor Construction');
    
    $suite->test(function($test){
        $processor = new \XPSPL\Processor(false);
        $test->false($processor->signal_history());
        $processor->emit(new \XPSPL\SIG('test'));
        $test->false($processor->signal_history());
    }, 'construct_no_history');

    $suite->test(function($test){
        $test->processor->signal(new \XPSPL\SIG('test'), new \XPSPL\Process(function(){}));
        $test->false($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
        $test->processor->emit(new \XPSPL\SIG('test'));
        $queue = $test->processor->find_signal_database(new \XPSPL\SIG('test'));
        $test->instanceof($queue, new \XPSPL\database\Processes());
        $test->count($queue->get_storage(), 0);
    }, 'auto_remove_exhausted');

    $suite->test(function($test){
        // String based
        $test->processor->register_signal(new \XPSPL\SIG(new \XPSPL\SIG('test')));
        $test->instanceof(
            $test->processor->find_signal_database(new \XPSPL\SIG(new \XPSPL\SIG('test'))), 
            'XPSPL\database\Signals'
        );
        $test->processor->delete_signal(new \XPSPL\SIG('test'));
        $test->null($test->processor->find_signal_database(SIG(new \XPSPL\SIG('test'))));
        $signal = new \XPSPL\SIG(new \XPSPL\SIG('test'));
        // Delete history
        $test->processor->signal(SIG($signal), new \XPSPL\Process(function(){}));
        $test->processor->emit(SIG($signal));
        $history = $test->processor->signal_history();
        // Need to implement a search history function ... ?
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $test->equal($count, 1);
        // Delete signal keep history
        $test->processor->register_signal($signal);
        $test->processor->delete_signal($signal, false);
        $history = $test->processor->signal_history();
        $count = 0;
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $test->equal($count, 1);
        // Delete signal remove history
        $test->processor->register_signal($signal);
        $test->processor->delete_signal($signal, true);
        $count = 0;
        $history = $test->processor->signal_history();
        foreach ($history as $_record) {
            if ($_record[1] === $signal) {
                $count++;
            }
        }
        $test->equal($count, 0);
    }, 'delete_signal');

    $suite->test(function($test){
        $test->processor->signal(new \XPSPL\SIG('test'), new \XPSPL\Process(function(){}));
        $test->false($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
        $test->processor->emit(new \XPSPL\SIG('test'));
        $test->true($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
    }, "has_signal_exhausted");

    $suite->test(function($test){
        $test->processor->signal(new \XPSPL\SIG('test'), new \XPSPL\Process(function(){}));
        $queue = $test->processor->find_signal_database(new \XPSPL\SIG('test'));
        $test->false($test->processor->are_processes_exhausted($queue));
        $test->processor->emit(new \XPSPL\SIG('test'));
        $test->true($test->processor->are_processes_exhausted($queue));
        $test->count($queue->get_storage(), 0);
    }, 'queue_exhausted');

    $suite->test(function($test){
        $test->processor->signal(new \XPSPL\SIG('test'), new XPSPL\Process(function(){}, null));
        $test->processor->emit(new \XPSPL\SIG('test'));
        $test->equal($test->processor->get_state(), STATE_DECLARED);
        $test->count($test->processor->signal_history(), 1);
        $test->instanceof(
            $test->processor->find_signal_database(new \XPSPL\SIG('test')), 
            new XPSPL\database\Processes()
        );
        $test->false($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
        $test->processor->flush();
        $test->equal($test->processor->get_state(), STATE_DECLARED);
        $test->null($test->processor->find_signal_database(new \XPSPL\SIG('test')));
        // $test->count($test->processor->signal_history(), 0);
    }, 'flush');

    $suite->test(function($test){
        $process = $test->processor->signal(new \XPSPL\SIG('test'), new \XPSPL\Process(function(){}));
        $test->instanceof($process, 'XPSPL\Process');
        $queue = $test->processor->find_signal_database(new \XPSPL\SIG('test'));
        $test->count($queue->get_storage(), 1);
        $test->false($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
        $test->processor->delete_process(new \XPSPL\SIG('test'), $process);
        $test->count($queue->get_storage(), 0);
        $test->true($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
    }, 'process,process_remove');

    $suite->test(function($test){
        class TL extends XPSPL\Listener {
            public function test($event) {
                $event->test = true;
            }
        }
        $test->processor->listen(new TL());
        $queue = $test->processor->find_signal_database(new \XPSPL\SIG('test'));
        if (!$test->notnull($queue)) {
            $test->mark_skipped(4);
            return;
        }
        if (!$test->instanceof($queue, 'XPSPL\database\Processes')) {
            $test->mark_skipped(3);
            return;
        }
        if (!$test->count($queue->get_storage(), 1)) {
            $test->mark_skipped(2);
            return;
        }
        $test->false($test->processor->has_signal_exhausted(new \XPSPL\SIG('test')));
        $event = $test->processor->emit(new \XPSPL\SIG('test'));
        $test->true($event->test);
    }, 'listen');

    $suite->test(function($test){
        $test->processor->register_signal(new \XPSPL\SIG('test'));
        $test->notnull($test->processor->find_signal_database(new \XPSPL\SIG('test')));
        $test->instanceof(
            $test->processor->find_signal_database(new \XPSPL\SIG('test')),
            'XPSPL\database\Processes'
        );
        class CMP extends XPSPL\SIG_Complex {
            public function evaluate($signal = false) {
                return true;
            }
        }
        $cmp = new CMP();
        $test->processor->register_signal($cmp);
        $test->notnull($test->processor->find_signal_database($cmp));
        $test->instanceof(
            $test->processor->find_signal_database($cmp),
            'XPSPL\database\Processes'
        );
        $db = $test->processor->find_signal_database($cmp, true);
        $test->instanceof($db, 'XPSPL\database\Processes');
    }, 'find_signal_database');

    $suite->test(function($test){
        class EVL extends XPSPL\SIG_Complex {
            public function evaluate($signal = null) {
                return true;
            }
        }
        class EVF extends XPSPL\SIG_Complex {
            public function evaluate($signal = null) {
                return false;
            }
        }
        $evl = new EVL();
        $evf = new EVF();
        $test->null($test->processor->evaluate_signals(new \XPSPL\SIG('test')));
        $test->processor->register_signal($evl);
        $test->processor->register_signal($evf);
        $eval = $test->processor->evaluate_signals(new \XPSPL\SIG('test'));
        $test->array($eval);
        $test->count($eval, 1);
        $test->processor->delete_signal($evl);
        $test->null($test->processor->evaluate_signals(new \XPSPL\SIG('test')));
    }, 'evaluate_signals');

    $suite->test(function($test){
        // Simple
        $test->processor->signal(new \XPSPL\SIG('before_after_test'), new \XPSPL\Process(function($signal) use ($test) {
            $test->isset('count', $signal);
            $test->equal($signal->count, 1);
            ++$signal->count;
        }));
        $test->processor->before(new \XPSPL\SIG('before_after_test'), new \XPSPL\Process(function($signal){
            $signal->count = 1;
        }));
        $test->processor->after(new \XPSPL\SIG('before_after_test'), high_priority(function($signal) use ($test){
            $test->equal($signal->count, 2);
        }));
        $test->processor->after(new \XPSPL\SIG('before_after_test'), new \XPSPL\Process(function($signal){
            ++$signal->count;
        }));
        $result = $test->processor->emit(new \XPSPL\SIG('before_after_test'));
        $test->isset('count', $result);
        $test->equal($result->count, 3);
    }, 'before,after');

    // NOT IMPLEMENTED
    // $suite->test(function($test){
    //     $test->processor->register_signal(new \XPSPL\SIG('test'));
    //     $test->notnull($test->processor->find_signal_database(new \XPSPL\SIG('test')));
    //     $test->instanceof(
    //         $test->processor->find_signal_database(new \XPSPL\SIG('test')), 
    //         new \XPSPL\database\Processes()
    //     );
    //     $test->processor->clean();
    //     $test->null($test->processor->find_signal_database(new \XPSPL\SIG('test')));
    //     $test->processor->register_signal(new \XPSPL\SIG('test'));
    //     $test->processor->signal(new \XPSPL\SIG('test'), function(){});
    //     $test->notnull($test->processor->find_signal_database(new \XPSPL\SIG('test')));
    //     $test->false($test->processor->queue_exhausted(
    //         $test->processor->find_signal_database(new \XPSPL\SIG('test'))
    //     ));
    //     $test->processor->emit(new \XPSPL\SIG('test'));
    //     $test->processor->clean(true);
    //     $test->null($test->processor->find_signal_database(new \XPSPL\SIG('test')));
    //     $test->count($test->processor->signal_history(), 0);
    // }, 'clean');
});