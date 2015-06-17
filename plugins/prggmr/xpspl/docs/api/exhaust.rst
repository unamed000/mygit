.. /exhaust.php generated using docpx on 04/23/13 11:40pm


Function - exhaust
******************


.. function:: exhaust($limit, $process)


    Registers the given process to have the given exhaust rate.
    
    A rated exhaust allows for you to install processes that exhaust at the set 
    rate rather than 1.
    
    If you require a null exhaust process use the ``null_exhaust`` function.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Defining process exhaust.
#########################

Defines the given process with an exhaust of 5.

.. code-block:: php

   <?php
   
   signal(SIG('foo'), exhaust(5, function(){
       echo 'foo';
   });

   for($i=0;$i<5;$i++){
       emit('foo');
   }
   
   // results
   // foofoofoofoofoo

Null exhaust process.
#####################

Install a process that never exhausts.

.. note::

    Once a null exhaust process is installed it must be removed using 
    ``delete_process``.

.. code-block:: php

    <?php

    signal(SIG('foo'), null_exhaust(function(){
        echo "foo";
    }));

    for ($i=0;$i<35;$i++) {
        emit(SIG('foo'));
    }
    // results
    // foo
    // foo
    // foo
    // foo
    // ...




Last updated on 04/23/13 11:40pm