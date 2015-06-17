<?php
namespace ftp;
/**
 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
 * Use of this source code is governed by the Apache 2 license
 * that can be found in the LICENSE file.
 */

/**
 * SIG_Complete
 * 
 * Emitted when a file as completed transfer.
 */
class SIG_Complete extends \XPSPL\Signal {

    protected $_unique = true;

}