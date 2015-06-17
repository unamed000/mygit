<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Echo Server
 *
 * This example demonstrates a simple echo server that spits back anything that
 * was sent and then disconnects.
 */
import('network');

$server = network\connect('0.0.0.0', ['port' => '1337']);

$server->on_connect(null_exhaust(function(network\SIG_Connect $sig_connect){
    if (null !== $sig_connect->socket) {
        echo "Connection " . PHP_EOL;
        $sig_connect->socket->write('HelloWorld');
        $sig_connect->socket->disconnect();
    }
}));

// $server->on_read(null_exhaust(function(network\SIG_Read $sig_read){
//     echo "Connection " . PHP_EOL;
//     $sig_read->socket->write($sig_read->socket->read());
//     $sig_read->socket->disconnect();
// }));