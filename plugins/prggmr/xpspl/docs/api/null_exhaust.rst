.. /null_exhaust.php generated using docpx on 04/23/13 11:40pm


Function - null_exhaust
***********************


.. function:: null_exhaust($process)


    Registers the given process to have a null exhaust.
    
    Be careful when registering a null exhaust process.
    
    Once registered it will **never** be purged from the processor.
    
    **Do not** register a null exhaust process unless you are absolutely sure you  
    want it to never exhaust.
    
    If you require a process to exhaust after a few executions use the ``rated_exhaust`` 
    function.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Install a null exhaust process.
###############################

This example installs a null exhaust process which calls an awake signal 
every 10 seconds creating an interval.

.. code-block:: php

   <?php
   import('time');
   
   time\awake(10, null_exhaust(function(){
       echo "10 seconds";
   }));




Last updated on 04/23/13 11:40pm