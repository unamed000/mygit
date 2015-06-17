<?php

import('time');
$precision = 1;
$signal = new \time\SIG_Awake($precision, TIME_SECONDS);
$signal->time = time();
$precision_timing = [];
signal($signal, exhaust(1000, function($signal) use ($precision, &$precision_timing){
    $timing = (intval(floatval((time() - $signal->time))) - $precision);
    echo $timing.PHP_EOL;
    if ($timing > 100000 || $timing < 0) {
        // Second change
        $timing = 0;
    }
    $precision_timing[] = [$timing, 0];
    $signal->time = time();
}));
on_shutdown(function() use (&$precision_timing){
    array_shift($precision_timing);
    $results = ['msPrecision' => $precision_timing];
    ob_start();
    include dirname(realpath(__FILE__)).'/chart.php';
    $data = ob_get_contents();
    ob_end_clean();
    file_put_contents('second_precision.html', $data);
    echo "Performance chart in second_precision.html".PHP_EOL;
});