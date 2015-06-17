.. src/logger.php generated using docpx on 02/04/13 10:38pm


Constants
---------

LOGGER_LOG_LEVEL
++++++++++++++++
LOGGER_LOG_LEVEL

The default log level code to use when logging messages.

Class - Logger
**************

Stupid simple logging utility for XPSPL based on Pythons logger.

Methods
-------

instance
++++++++

.. function:: instance()


    Returns an instance of the singleton.
    
    Passes args to constructor



__clone
+++++++

.. function:: __clone()


    Disallow cloning



add_handler
+++++++++++

.. function:: add_handler($handler)


    Adds a handler.

    :param object: HJandler

    :rtype: void 



log
+++

.. function:: log($code, $message)


    Logs a message.

    :param integer: Log level code.
    :param string: Message to log.

    :rtype: void 



debug
+++++

.. function:: debug($message)


    Logs a debug message.

    :param string: Message to log.

    :rtype: void 



info
++++

.. function:: info($message)


    Logs a info message.

    :param string: Message to log.

    :rtype: void 



warning
+++++++

.. function:: warning($message)


    Logs a warning message.

    :param string: Message to log.

    :rtype: void 



error
+++++

.. function:: error($message)


    Logs a error message.

    :param string: Message to log.

    :rtype: void 



critical
++++++++

.. function:: critical($message)


    Logs a critical message.

    :param string: Message to log.

    :rtype: void 



get_logger
++++++++++

.. function:: get_logger($logger)


    Returns a new logger.

    :param string: Name of the logger.

    :rtype: object Logger



Constants
---------

DEBUG
+++++
DEBUG

Detailed information, typically of interest only when diagnosing 
problems.

INFO
++++
INFO

Confirmation that things are working as expected.

WARNING
+++++++
WARNING 

An indication that something unexpected happened, or indicative of
some problem in the near future (e.g. ‘disk space low’). 
 
The software is still working as expected.

ERROR
+++++
ERROR

Due to a more serious problem, the software has not been able to 
perform some function.

CRITICAL
++++++++
CRITICAL   

A serious error, indicating that the program itself may be unable 
to continue running.

Class - Handler
***************

Handler

Handles a log message

Methods
-------

__construct
+++++++++++

.. function:: __construct($formatter, $output, [$level = 2])


    Sets the formatter.

    :param object: 
    :param resource: Output resource or file
    :param integer: Code level to log, anything greater than the 
                         given code will be logged.

    :rtype: void 



handle
++++++

.. function:: handle($code, $message)


    Handles a message.

    :param integer: Log level code.
    :param string: Message to handle.

    :rtype: void 



_make_writeable
+++++++++++++++

.. function:: _make_writeable()


    Makes the output writeable.
    
    This will create a non-blocking stream to the given file.

    :rtype: boolean 



Class - Formatter
*****************

Formatter

Formats a log message.

The formatter allows for the following parameters.

%date - Date of the log
%message - Log message
%code - Error Code Level
%str_code - String representation of the error code

Methods
-------

__construct
+++++++++++

.. function:: __construct($format)


    Create a formatter.

    :param object: String format to log a message

    :rtype: void 



format
++++++

.. function:: format($code, $message)


    Handles a message.

    :param integer: Log level code.
    :param string: Message to handle.

    :rtype: void 



psprintf
++++++++

.. function:: psprintf()


    Returns a formatted string. Accepts named arguments.



Function - logger
*****************


.. function:: logger([$name = false])


    Returns a logger identified by the given name.
    
    If the logger does not exist it is created.

    :param string: Name of the logger

    :rtype: object Logger




Last updated on 02/04/13 10:38pm