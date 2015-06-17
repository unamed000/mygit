.. idle/time.php generated using docpx on 02/01/13 07:27am


Class - XPSPL\\idle\\Time
*************************

Idles the processor for a specific amount of time.

The amount of time can be specified in seconds or milliseconds.

Methods
-------

__construct
+++++++++++

.. function:: __construct($time, $instruction)


    Constructs the time idle.



idle
++++

.. function:: idle($processor)


    Runs the idle function, this will call either sleep or usleep
    depending upon the type.

    :rtype: void 



get_length
++++++++++

.. function:: get_length()


    Returns the length of time to idle.

    :rtype: integer 



get_time_until
++++++++++++++

.. function:: get_time_until()


    Returns the length of time to idle until.

    :rtype: integer 



get_instruction
+++++++++++++++

.. function:: get_instruction()


    Returns the type of time.

    :rtype: integer 



get_time_left
+++++++++++++

.. function:: get_time_left()


    Returns the amount of time left until the idle should stop.

    :rtype: integer|float 



convert_length
++++++++++++++

.. function:: convert_length($length, $to)


    Converts length of times from and to seconds, milliseconds and 
    microseconds.

    :param integer|float: 
    :param integer: To instruction

    :rtype: integer|float 



has_time_passed
+++++++++++++++

.. function:: has_time_passed()


    Determines if the time to idle until has passed.

    :rtype: boolean 



override
++++++++

.. function:: override($time)


    Determine if the given time idle function is less than the current.

    :param object: Time idle object

    :rtype: boolean 




Last updated on 02/01/13 07:27am