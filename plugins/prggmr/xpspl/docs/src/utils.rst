.. utils.php generated using docpx on 02/01/13 07:27am


Function - milliseconds
***********************

milliseconds
============

.. function:: milliseconds()


    Returns the current time since epox in milliseconds.

    :rtype: integer 



Function - microseconds
***********************

microseconds
============

.. function:: microseconds()


    Returns the current time since epox in microseonds.

    :rtype: integer 



Function - signal_exceptions
****************************

signal_exceptions
=================

.. function:: signal_exceptions($exception)


    Transforms PHP exceptions into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_EXCEPTION

    :param object: \Exception

    :rtype: void 



Function - signal_errors
************************

signal_errors
=============

.. function:: signal_errors($errno, $errstr, $errfile, $errline)


    Transforms PHP errors into a signal.
    
    The signal fired is \XPSPL\processor\Signal::GLOBAL_ERROR

    :param int: 
    :param string: 
    :param string: 
    :param int: 

    :rtype: void 



Function - bin_search
*********************

bin_search
==========

.. function:: bin_search($needle, $haystack, [$compare = false])


    Performs a binary search for the given node returning the index.
    
    Logic:
    
    0 - Match
    > 0 - Move backwards
    < 0 - Move forwards

    :param mixed: Needle
    :param array: Hackstack
    :param closure: Comparison function

    :rtype: null|integer index, null locate failure



Function - get_class_name
*************************

get_class_name
==============

.. function:: get_class_name([$object = false])


    Returns the name of a class using get_class with the namespaces stripped.
    This will not work inside a class scope as get_class() a workaround for
    that is using get_class_name(get_class());

    :param object|string: Object or Class Name to retrieve name

    :rtype: string Name of class with namespaces stripped



Constants
---------

XPSPL_AUTOLOADER
++++++++++++++++
Autoloader


Last updated on 02/01/13 07:27am