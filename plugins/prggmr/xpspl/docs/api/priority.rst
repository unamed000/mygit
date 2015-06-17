.. /priority.php generated using docpx on 04/23/13 11:40pm


Function - priority
*******************


.. function:: priority($priority, $process)


    Registers the given process to have the given priority.
    
    This allows for controlling the order of processes rather than using FIFO.
    
    Priority uses an ascending order where 0 > 1.
    
    Processes registered with a high priority will be executed before those with 
    a low or default priority.
    
    Process priority is handy when multiple process will execute and their order 
    is important.
    
    .. note::
    
       This is not an interruption.
       
       Installed interruptions will still be executed before or after a 
       prioritized process.

    :param integer: Priority to assign
    :param callable|process: PHP Callable or \XPSPL\Process.

    :rtype: object Process


Installing multiple priorities
##############################

This installs multiple process each with a seperate ascending priority.

.. code-block:: php

   <?php
   
   signal('foo', priority(0, function(){
       echo 'foo';
   }));
   
   signal('foo', priority(3, function(){
       echo 'bar';
   }));
   
   signal('foo', priority(5, function(){
       echo 'hello';
   }));
   
   signal('foo', priority(10, function(){
       echo 'world';
   }));

   // results when foo is emitted
   // foobarhelloworld




Last updated on 04/23/13 11:40pm