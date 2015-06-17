<?php

import('time');
$precision = 1000;
$signal = new \time\SIG_Awake($precision, TIME_MILLISECONDS);
$signal->time = milliseconds();
$precision_timing = [];
signal($signal, exhaust(10, function($signal) use ($precision, &$precision_timing){
    $timing = (intval(floatval((milliseconds() - $signal->time))) - $precision);
    echo $timing.PHP_EOL;
    if ($timing > 100000) {
        // Second change
        $timing = 0;
    }
    $precision_timing[] = [$timing, 0];
    $signal->time = milliseconds();
}));
on_shutdown(function() use (&$precision_timing){
    array_shift($precision_timing);
    $results = ['msPrecision' => $precision_timing];
    ob_start();
    include dirname(realpath(__FILE__)).'/chart.php';
    $data = ob_get_contents();
    ob_end_clean();
    file_put_contents('millisecond_precision.html', $data);
    echo "Performance chart in millisecond_precision.html".PHP_EOL;
});