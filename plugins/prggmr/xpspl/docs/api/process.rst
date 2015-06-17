.. /process.php generated using docpx on 04/23/13 11:40pm


Function - process
******************


.. function:: process($callable)


    Creates a new XPSPL Process object.
    
    .. note::
       
       See the ``priority`` and ``exhaust`` functions for setting the priority 
       and exhaust of the created process.

    :param callable: 

    :rtype: void 


Creates a new XPSPL Process object.
###################################

.. code-block::php

   <?php
   
   $process = process(function(){});

   signal(SIG('foo'), $process);




Last updated on 04/23/13 11:40pm