<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * Chat Server
 *
 * This example demonstrates how to build a simple TCP chat server which can
 * be connected using telnet.
 */
import('network');

$socket = network\connect('0.0.0.0', ['port' => '8000'], function(){
    echo "Server Running on " . $this->socket->get_address() . PHP_EOL;
});

$socket->on_client(function() use ($socket){
    $this->socket->write("Welcome to the prggmr chat server".PHP_EOL);
    $this->socket->write("Enter your username : ");
});

$socket->on_read(function() use ($socket){
    $clients = $socket->get_clients();
    $client = $clients[$this->socket->get_resource()];
    // Strip any newlines from linux
    $content = implode("", explode("\r\n", $this->socket->read()));
    // windows
    $content = implode("", explode("\n\r", $content));
    // On first connection read in the username
    if (!isset($client->username)) {
        $client->username = $content;
        $this->socket->write("Welcome $content".PHP_EOL);
        foreach ($clients as $_client) {
            if ($_client != $this->socket) {
                $_client->write(sprintf(
                    '%s has connected'.PHP_EOL,
                    $content
                ));
            }
        }
        $connected = [];
        foreach ($clients as $_client) {
            if (isset($_client->username)) {
                $connected[] = $_client->username;
            }
        }
        $this->socket->write(sprintf(
            "%s User Online (%s)".PHP_EOL, 
            count($connected), 
            implode(", ", $connected)
        ));
    } else {
        foreach ($clients as $_client) {
            if ($_client != $this->socket) {
                $_client->write(sprintf(
                    '%s : %s'.PHP_EOL,
                    $client->username,
                    $content
                ));
            }
        }
    }
});

$socket->on_disconnect(function() use ($socket){
    $clients = $socket->get_clients();
    $client = $clients[$this->socket->get_resource()];
    foreach ($clients as $_client) {
        if ($_client != $this->socket) {
            $_client->write(sprintf(
                '%s Disconnected'.PHP_EOL,
                $client->username
            ));
        }
    }
});