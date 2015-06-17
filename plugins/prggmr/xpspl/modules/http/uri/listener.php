<?php
namespace XPSPL\http\uri;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

use \XPSPL\http as http;

/**
 * Allows for listening to URI signals.
 */
class Listener extends \XPSPL\Listener 
{
    /**
     * Constructs a new URI listener.
     *
     * @param  object  $event  Event to use
     *
     * @return  void
     */
    public function __construct($event = null) 
    {
        foreach (get_class_methods($this) as $_method) {
            // skip magic methods
            if (stripos('_', $_method) === 0) continue;
            if (stristr($_method, 'on_') === false) continue;
            if (isset($this->$_method)) {
                $route = $this->{$_method};
                if (is_array($route)) {
                    $uri = $route[0];
                    $method = $route[1];
                } else {
                    $uri = $route;
                    $method = null;
                }
                $_signal = new http\Uri($uri, $method, $event);
            } else {
                $_signal = str_replace('on_', '', $_method);
            }
            $this->_sig_processs[] = [
                array($this, $_method),
                $_signal
            ];
        }
    }
}