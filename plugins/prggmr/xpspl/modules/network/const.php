<?php
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * IPV6 Support
 */
define('XPSPL_NETWORK_IPV6', true);

if (!defined('XPSPL_NETWORK_TIMEOUT_MICROSECONDS')) {
    define('XPSPL_NETWORK_TIMEOUT_MICROSECONDS', 0);
}

if (!defined('XPSPL_NETWORK_TIMEOUT_SECONDS')) {
    /**
     * Default timeout length in seconds for connections.
     */
    define('XPSPL_NETWORK_TIMEOUT_SECONDS', 30);
}

if (!defined('XPSPL_SOCKET_READ_LENGTH')) {
    /**
     * Amount of data to read in on read in bytes.
     */
    define('XPSPL_SOCKET_READ_LENGTH', 2000000);
}