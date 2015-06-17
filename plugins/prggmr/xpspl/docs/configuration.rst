.. configuration::

Configuration
=============

Configuration values are defined using constants before loading XPSPL.

Constants
---------


XPSPL_DEBUG
+++++++++++
XPSPL Debug mode

When turned on XPSPL generates a log of all activity to STDOUT.

When turned off XPSPL removes its processor traces from uncaught exceptions.

XPSPL_SIGNAL_HISTORY
++++++++++++++++++++
Signal History

Default setting for the saving the signal history. 

By default this is ``false``.

XPSPL_PURGE_EXHAUSTED
+++++++++++++++++++++
Remove Exhausted processes

When turned on this automatically removes installed processes from the 
processor once it determines they can no longer be used.

By default this settings is ``true``.

XPSPL_MODULE_DIR
++++++++++++++++
Module Directory

Directory to look for modules.

By default it is set to the ``module`` directory in XPSPL.

XPSPL_PROCESS_DEFAULT_EXHAUST
+++++++++++++++++++++++++++++
Default process exhaustion

Integer option defining the default exhausting of a process.

By default it is ``1``.

XPSPL_PROCESS_DEFAULT_PRIORITY
++++++++++++++++++++++++++++++
Process default priority

Integer option defining the default priority of all processes.

By default it is ``10``.

XPSPL_JUDY_SUPPORT
++++++++++++++++++
Judy is an optional database configuration.

http://xpspl.prggmr.org/en/xspel/install.html#optional

Currently this is experimental as an attempt to improve performance.

Once stable this will automatically be enabled if Judy is detected.

XPSPL_ANALYZE_TIME
++++++++++++++++++
**UNUSED**

This is an unused configuration option that will later add support 
for analyzing the processor timing to auto correct signal timing ... at least 
that is the theory.

Last updated on 04/23/13 11:50pm
