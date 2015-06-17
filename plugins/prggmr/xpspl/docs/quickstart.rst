Quickstart
----------

This guide covers the following topics,

.. contents::

Signal Driven Programming with XPSPL
====================================

Signal driven programming is the development of software using a design where 
the flow is determined by signals.

It relies heavily on the use of event processes, interruptions, mutable data and 
insane levels of decoupling.

If you know GUI this will feel very familiar.

The idea is nothing new and is in use right now on the device your reading this 
with, unless your on paper.

Designing software using SDP is not much different than designing it using 
OOP or functional type designs only in that it provides programmers more power 
in directing and interrupting flow.

SDP is not a replacement for your current software design.

In many situations SDP is not the choice for performing a process.

SDP is only a good candidate under the following circumstances,

   * The software must be a long served process that can handle tens to thousands 
     of separate operations occurring at any given time.

   * The software has the probability that it will require enhancements to it's 
     core flow causing potential rewrites of production stable versions.

   * Many concurrent unrelated processes must be performed using the same data.

It should be mentioned that SDP suites well for short-lived software as 
seen with most standard PHP web applications.

Examples
________

These examples are not real world and are for informational purposes only.

Echo Server
%%%%%%%%%%%

This example is a network server that echos the client back it's own data it 
sent.

.. code-block:: php

    <?php
    /**
    * Echo Server
    *
    * This example demonstrates a simple echo server that spits back anything that
    * was sent and then disconnects.
    */
   import('network');
   
   $socket = network\connect('0.0.0.0', ['port' => '1337'], function(){
       echo "Server Running on " . $this->socket->get_address() . PHP_EOL;
   });
   
   $socket->on_client(null_exhaust(function(){
       echo "Connection " . PHP_EOL;
       $this->socket->write($this->socket->read());
       $this->socket->disconnect();
   }));

Flow Interruptions
%%%%%%%%%%%%%%%%%%

This example demonstrates interruption the flow of a signal.

.. code-block:: php

  <?php
  
  // When foo is emitted insert bar into the event
  before('foo', function(){
      echo "I RAN";
      $this->bar = 'foo';
  });
  
  // Handle Foo
  signal('foo', function(){
      echo $this->bar;
  });
  
  // After foo is emitted unset bar in the event
  after('foo', function(){
      unset($this->bar);
  });
  
  emit('foo');

FTP Upload
%%%%%%%%%%

This examples demonstrates uploading a file to a remote server using FTP.

.. code-block:: php

    <?php

    import('ftp');
    
    $files = ['/tmp/myfile_1.txt', '/tmp/myfile_2.txt'];
    $server = [
        'hostname' => 'ftp.myhost.com',
        'username' => 'foo',
        'password' => 'bar'
    ];
    
    $upload = ftp\upload($files, $server, function(){
        echo "Upload Started";
    });
    
    ftp\complete($upload, null_exhaust(function(){
        $file = $this->get_file();
        echo sprintf('%s has uploaded'.PHP_EOL,
            $file->get_name()
        );
    }));
    
    ftp\failure($upload, null_exhaust(function(){
        $file = $this->get_file();
        echo sprintf('%s has failed to upload'.PHP_EOL,
            $file->get_name()
        );
    }));

    ftp\finished($upload, function(){
        echo "Upload complete";
    });

XPSPL The PHP Signal Library
============================

History
_______

Code for XPSPL began sometime in 2008 as a project to learn EDP, though the name 
and design have changed a few times since then, the goal of changing the way we 
write software has not.

On Nov 10, 2010 an early version was uploaded to the open-source community.

By late 2011 XPSPL began use in production stable software and continues to this 
day.

Limitations
___________

I always find it is best to know what something can't do before what it can.

Here is a list of unsupported features,

    * Threads and forks
    * epoll, kqueue, poll (select is supported)
    * Guaranteed real time

A suitable epoll, kqueue and poll module is planned but requires funding.

Contributions for these features are always appreciated.

API
___

XPSPL's API is designed to provide programmers with a natural speaking, 
intuitive API.

The API has been extensively redesigned based on instinctual memory and usage 
feedback from a team of highly skilled programmers.

Non-Modular API functions are not namespaced and should not provide any collisions 
with your existing system*.

.. note::

    *Due to unknown system configurations it cannot be guaranteed that collisions
    wont exist.

Samples
%%%%%%%

OOP
^^^

.. code-block:: php

   <?php

   /**
    * This is a standard class used for math operations.
    */
   class Math {

      /**
       * This method will add the two numbers giving.
       */
      public function add($num_1, $num_2) 
      {
         return $num_1 + $num_2;
      }

   }

   /**
    * Add two numbers using our class.
    */
   $math = new Math();
   echo $math->add(1, 4);

   // Results
   5

OOP XPSPL
^^^^^^^^^

.. code-block:: php

    <?php

    /**
    * This is standard listener used for math operations.
    */
    class Math {

      /**
       * Receive the add signal.
       */
      public function add($signal)
      {
        return $signal->num_1 + $signal->num_2;
      }
    }

    listen(new Math());
    emit('add', new Signal(['num_1' => 1, 'num_2' => 4]));

    // Results
    5;

Functional
^^^^^^^^^^

.. code-block:: php

    <?php

    /**
    * This is a standard function for adding to numbers.
    */
    function add($num_1, $num_2) 
    {
        return $num_1 + $num_2;
    }

    echo add(1, 4);

    // Results
    5

Functional XPSPL
^^^^^^^^^^^^^^^^

.. code-block:: php

    <?php

    /**
    * This is a standard process for adding to numbers.
    */
    function add($process)
    {
        return $process->num_1 + $process->num_2;
    }

    signal('add', add);
    emit('add', new Signal(['num_1' => 1, 'num_2' => 4]));

    // Results
    5

Closures
^^^^^^^^

.. code-block:: php

    <?php

    $add = function($num_1, $num_2) {
        return $num_1 + $num_2;
    }

    echo $add(1, 4);

    // Results
    5

Closure XPSPL
^^^^^^^^^^^^^

.. code-block:: php

    <?php

    signal('add', function(){
        return $this->num_1 + $this->num_2;
    });

    emit('add', new Signal(['num_1' => 1, 'num_2' => 4]));

    // Results
    5

Environment
===========

XPSPL is designed to run applications from within a signal loop.

It ships with the ``xpspl`` command for transparently loading into the environment.

XPSPL understands the following commands.

  usage: XPSPL [-c|--config=<file>] [-d] [-h|--help] [-p|--passthru] [--test]
                [--test-cover] [-t|--time=<time>] [-v|--version] [-j|--judy]
                <file>
  Options:
    -c/--config   Load the giving file for configuration
    -d            XPSPL Debug Mode
    -h/--help     Show this help message.
    -j/--judy     Enable judy support
    -p/--passthru Ignore any subsequent arguments and pass to <file>.
    --test        Run the XPSPL unit tests.
    --test-cover  Run unit tests and generate code coverage.
    --update      Update XPSPL to the latest available version.
    -t/--time     Run for the given amount of milliseconds.
    -v/--version  Displays current XPSPL version.

How it works
____________

With XPSPL your not calling functions rather your sending signals.

You develop your application to install signal processors on load using the XPSPL API.

Your application then emits the signals you have installed, at a very high level this is no different than calling 
a function.

The advantage to this is that unlike a function call a signal is caught, can be interrupted and allows for performing processes 
using a completely decoupled but shared architecture. 

Starting applications
_____________________

Applications are started using a main file loaded with the ``xpspl`` command.

.. code-block:: console

   $ xpspl main.php

Managing applications
_____________________

Currently XPSPL does not support managing itself as a daemon.

We currently use runit for managing long lived processes, though any process manager you are familiar with will work just as well.

Short lived applications
_______________________

For applications that will have a very short life cycle, such as those typically loaded from an external interface (an HTTP Request) 
you will need to manually load and enter your application into the event loop.

To do so you can use the following code as your ``index.php``.

.. code-block:: php

   <?php
   // Define any configuration options here
   // ...
   // ...
   // ...
   
   // load the XPSPL library
   require_once 'XPSPL/src/XPSPL.php';

   // This would be your main file.
   require_once 'main.php';
   
   // Start the signal loop
   loop();

.. note::

   Notice the last line calls ``loop``? 

   This must be the last line of code executed in your application since this will block anything that follows.


.. Signals, Handles and Events
.. ===========================

.. Signals
.. _______

.. A signal is the introduction of change within an application.

.. They are represented as classes or strings using two seperate types.

.. Standard
.. ********

.. Standard signals are signals which do not require a computation to trigger, can be represented in string form, are triggered via the ``XPSPL\signal`` function and extend the ``XPSPL\Signal`` class.

.. Examples
.. %%%%%%%%

.. .. code-block:: php

..    <?php
..    // Register a new simple signal as a string
..    XPSPL\register('foo');
   
..    // Register a new simple signal as a class
..    class Bar extends XPSPL\Signal {}
..    XPSPL\register(new Bar());

.. Complex
.. *******

.. Complex signals are signals which do require a computation to trigger, cannot be represented in string form, cannot be triggered via the ``XPSPL\signal`` function and extend the ``XPSPL\signal\Complex`` class.

.. The computations required to trigger fall into two seperate types of categories, an evaluation and routine.

.. Evaluations
.. %%%%%%%%%%%

.. A complex signal evaluation is the process in which a signal will analyze the currently processing signal to determine its execution possibilities.

.. Routines
.. %%%%%%%%

.. A routine is a signal which runs with each loop iteration for analyzing the past and present events that have taken place to determine its execution possibilities for now and in the future.

   
