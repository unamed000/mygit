<?php
namespace unittest;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * API can be included to load the entire signal.
 */

/**
 * Add a new assertion function.
 * 
 * @param  closure  $function  Assertion function
 * @param  string  $name  Assertion name
 * @param  string  $message  Message to return on failure.
 * 
 * @return  void
 */
function create_assertion($function, $name, $message = null) {
    return Assertions::instance()->create_assertion($function, $name, $message);
}

/**
 * Creates a new test case.
 * 
 * @param  object  $function  Test function
 * @param  string  $name  Test name
 * 
 * @return  array  [Process, Signal]
 */
function test($function, $name = null) {
    return signal(new SIG_Test($name), $function);
}

/**
 * Constructs a new unit testing suite.
 * 
 * @param  object  $function  Closure
 * 
 * @return  void
 */
function suite($function) {
    $suite = new SIG_Suite($function);
    register_signal($suite);
    return $suite;
}

/**
 * Registers a standard output mechanism for test results.
 * 
 * @return  void
 */
function generate_output() {

    // enable the event history
    set_signal_history(true);

    // Startup
    on_start(function(){
        if (XPSPL_DEBUG){
            logger(XPSPL_LOG)->info('Unittest begin');
        }
        define('UNITTEST_START_TIME', milliseconds());
    });

    // Shutdown
    on_shutdown(function(){
        if (XPSPL_DEBUG){
            logger(XPSPL_LOG)->info('Unittest end');
        }
        define('UNITTEST_END_TIME', milliseconds());
        $tests = 0;
        $pass = 0;
        $fail = 0;
        $skip = 0;
        $output = Output::instance();
        $tests_run = [];
        foreach (signal_history() as $_node) {
            if ($_node[0] instanceof SIG_Test) {
                // suites
                $tests++;
                $tests_run[] = $_node[0];
                $failures = [];
                // Get passedXPSPL 
                foreach ($_node[0]->get_assertion_results() as $_assertion) {
                    if ($_assertion[0] === true) {
                        $pass++;
                    } elseif ($_assertion[0] === null) {
                        $skip++;
                    } else {
                        $fail++;
                        $failures[] = $_assertion;
                    }
                }

                if (count($failures) != 0) {
                    $output->send_linebreak(Output::ERROR);
                    foreach ($failures as $_failure) {
                        $output->send("FAILURE", Output::ERROR);
                        $output->send("ASSERTION : " . $_failure[1], Output::ERROR, true);
                        $output->send("MESSAGE : " . $_failure[0], Output::ERROR, true);
                        $output->send(sprintf(
                            'ARGUMENTS : %s',
                            $output->variable($_failure[2])
                        ), Output::ERROR, true);
                        $trace = $_failure[3][1];
                        $output->send("FILE : " . $trace["file"], Output::ERROR, true);
                        $output->send("LINE : " . $trace["line"], Output::ERROR);
                        $output->send_linebreak(Output::ERROR);
                    }
                }
            }
        }
        $size = function($size) {
            /**
             * This was authored by another individual by whom i don't know
             */
            $filesizename = array(
                " Bytes", "KB", "MB", "GB", 
                "TB", "PB", " EB", "ZB", "YB"
            );
            return $size ? round(
                $size/pow(1024, ($i = floor(log($size, 1024)))), 2
            ) . $filesizename[$i] : '0 Bytes';
        };
        $output->send_linebreak();
        $output->send(sprintf(
            "Ran %s tests in %sms and used %s memory", 
            $tests,
            UNITTEST_END_TIME - UNITTEST_START_TIME,
            $size(memory_get_peak_usage())
        ), Output::SYSTEM, true);

        $output->send(sprintf("%s Assertions: %s Passed, %s Failed, %s Skipped",
            $pass + $fail + $skip,
            $pass, $fail, $skip
        ), Output::SYSTEM, true);

    });
}