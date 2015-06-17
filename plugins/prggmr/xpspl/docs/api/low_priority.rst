.. /low_priority.php generated using docpx on 04/23/13 11:40pm


Function - low_priority
***********************


.. function:: low_priority($process)


    Registers the given process to have a low priority.
    
    Processes registered with a low priority will be executed after those with 
    a high and default priority.
    
    This allows for controlling the order of processes rather than using FIFO.
    
    A low priority process is useful when multiple processes will execute and it 
    must always be one of the very last to run.
    
    This registers the priority as *PHP_INT_MAX*.
    
    .. note::
    
       This is not an interruption.
       
       Installed interruptions will still be executed after a low priority 
       process.

    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Install a process with low priority
###################################

Low priority processes always execute last.

.. code-block:: php

   <?php
   
   signal('foo', function(){
       echo 'foo';
   });
   
   signal('foo', low_priority(function(){
       echo 'bar';
   }));

   // results when foo is emitted
   // foobar




Last updated on 04/23/13 11:40pm