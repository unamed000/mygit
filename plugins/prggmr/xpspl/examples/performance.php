<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */
ini_set('memory_limit', -1);

if (function_exists('xdebug_start_code_coverage')) {
    exit('xdebug code coverage detected disable to run performance tests');
}

import('unittest');

$output = unittest\Output::instance();

$tests = [
    // 'Processes Installed' =>
    // function($i){
    //     signal(SIG($i), null); 
    // },
    'Signals Emitted' => 
    function($i){
        emit($i);
    },
    // 'Signal Registration' =>
    // function($i){
    //     register_signal(SIG($i)); 
    // },
    // 'Listners Installed' => 
    // function($i) {
    //     listen(new Lst());
    // },
    // // 'Interruptions Installed' =>
    // // function($i){
    // //     before($i, function(){}); 
    // // },
    'Loops Performed' => 
    function($i) {
        wait_loop();
    },
    // 'Interruption before emit' => 
    // function($i) {
    //     before($i, function(){});
    //     emit($i);
    // },
    // 'Interruption after emit' => 
    // function($i) {
    //     after($i, function(){});
    //     emit($i);
    // },
    // 'Complex Signal Registration' => 
    // function($i) {
    //     register_signal(new Cmp());
    // },
    // 'Complex Signal Evaluation' => 
    // function($i, $setup){
    //     if ($setup) {
    //         signal(new Cmp(), null_exhaust(function(){}));
    //     }
    //     emit('foo');
    // },
    // 'Complex Signal Registration' => 
    // function($i) {
    //     register_signal(new Cmp());
    // },
    // 'Complex Signal Evaluation' => 
    // function($i, $setup){
    //     if ($setup) {
    //         signal(new Cmp(), null_exhaust(function(){}));
    //     }
    //     emit('foo');
    // },
    // 'Complex Signal Interruption Before Install' => 
    // function($i, $setup){
    //     before(new Cmp(), function(){});
    // },
    // 'Complex Signal Interruption After Install' => 
    // function($i, $setup){
    //     after(new Cmp(), function(){});
    // },
    // 'Complex Signal Interruption Before' => 
    // function($i, $setup){
    //     before(new Cmp(), function(){});
    //     emit(new Cmp());
    // },
    // 'Complex Signal Interruption After' => 
    // function($i, $setup){
    //     after(new Cmp(), function(){});
    //     emit(new Cmp());
    // },
];

$output::send('Beginning performance tests');
$results = [];
$average_perform = 2;
foreach ($tests as $_test => $_func) {
    $results[$_test] = [];
    for ($i=1;$i<$average_perform+1;$i++) {
        $output::send(sprintf(
            'Running %s test %s of %s',
            $_test,
            $i, $average_perform
        ));
        for($a=1;$a<(1 << 16);) {
            $a = $a << 1;
            $tc = $a;
            echo $a.PHP_EOL;
            if ($a === 1) {
                $setup = true;
            } else {
                $setup = false;
            }
            if (!isset($results[$_test][$tc])) {
                $results[$_test][$tc] = [];
            }
            $start = microtime(true);
            for ($c=0;$c<$tc;$c++) {
                $_func($c, $setup);
            }
            $end = microtime(true);
            $results[$_test][$tc][] = $end - $start;
            XPSPL_flush();
        }
    }
    $output::send(sprintf(
        'Test %s complete',
        $_test
    ));
}
var_dump($results);
exit;
ob_start();
include dirname(realpath(__FILE__)).'/performance/chart.php';
$data = ob_get_contents();
ob_end_clean();
file_put_contents('performance_chart.html', $data);
echo "Performance chart in performance_chart.html".PHP_EOL;
