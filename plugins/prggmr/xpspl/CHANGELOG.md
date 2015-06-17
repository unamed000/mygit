## 3.0.0 01202013

* Moved the Queue into the \XPSPL\database namespace.
* Removed the Process::set_priority method
* Queue priority is now index based
* Removed the Queue::sort method
* Added Judy as the Database array.
* save_signal_history rennamed to set_signal_history
* Processor::search_signals renamed to Processor::find_signal_database
* State::get/set_state are now final.
* signal\Standard renamed to SIG_Base
* Signal renamed to SIG
* signal\Complex renamed to SIG_Complex
* Removed constant XPSPL_ENGINE_EXCEPTIONS
* Default exception handler added that removes redudant processor steps
* Exceptions are now thrown
* Handle renamed to Process
* Routine reset no longer resets the idle object.
* Idle and Routine objects are now in the global XPSPL namespace.
* Renamed engine\signal\* to processor\SIG_*
* All signal object now prepend SIG_.
* Engine renamed to processor
* Moved API functions into global namespace.
* Project renamed to XPSPL
* Added the API function on_shutdown, on_start, current_event, current_signal
  dir_include.
* Added the "count" assertion method to the unittest module
* module directory moved out of src.
* Exhausted handles are now immediatly removed from the engine.
* Added constants PRGGMR_MODULE_DIR and PRGGMR_PURGE_EXHAUSTED.

## 2.0.1 102412

* Signals now default to their class name if no information is provided.

## 2.0.0 100812

* Added API functions before, after
* Removed signal_interrupt API function
* Added EXHUAST_DEFAULT constant
* search_signals now returns only the Queue object or null
* Renamed load_module to load_module
* Renamed src/signal to src/modules
* Added the engine\event\Error class which is now passed to all engine error 
  signals.
* Added the terminate function the pcntl sig API
* Added the pcntl\Terminate signal
* signal\pcntl\Interrupt now extends the pcntl\Signal
* Added the pctnl Signal object
* Added the objects signal library
* Signal::info renamed to Signal::get_info
* Queues no longer allow for MIN,MAX heaps and work properly as FIFO
* Added evaluate_signals and search_signals to the engine
* Removed the _search and _search_complex methods in the engine
* Added PRGGMR_AUTOLOAD_STRICT constant
* Completely removed the ability to pass vars as a parameter throughout
* Priority and exhaustion must now be defined in the handle object and cannot
  be assigned directly via the handle function
* Removed the ENGINE_ROUTINE_SIGNAL constant
* Engine::signal_queue renamed to Engine::register
* Added the engine\Routine class
* Autoloading is now used for classes
* Engine now uses the prggmr\engine\Idle class for idling
* Added the microseconds function
* Added the socket signal with support for a socket server.
* Added Micheal Dowling to the CREDITS file.
* Added the cron-expression vendor library.
* Added the signal\time\cron API function.
* Added the signal\time\Cron signal.
* Removed the engine_code function
* Renamed EngineException to Engine_Exception
* Removed handle_loader from the engine
* Added the prggmr\engine\signal classes used for engine signals
* Removed the prggmr\engine\Signals class
* signal_queue function rewritten to return either false or the queue
* _search and _search_complex no longer return the type of return
* Added the has_signal_exhausted function to engine's public API.
* Complex signals are now stored using their hash for faster lookups
* Can now use any callable for a handle
* Engine::_interrupt is not private
* Added the signal_this method to the Complex signal object
* Removed the interval and timeout methods from prggmr's main API
* Added the get_routine method to the Complex signal.
* Added add_dispatch_signal, set_idle_time, set_idle_function to the Routine
  object.
* Removed the ENGINE_EXCEPTIONS and EVENT_HISTORY constants
* Added the disable_signaled_exceptions, init, enable_signaled_exceptions and
  erase_history functions to both the API and engine.
* Routine signals now all dispatch through the signal method rather than calling
  the _execute method directly
* Added the signal\Routines class
* Engine routine now uses the get_idle_time and event_history flags
  on construction.

## 1.2.4 060712
* Added pcntl signal library                                  

## 1.2.3 052112 
* Account for the BASE_URI setting in the http\Uri signal

## 1.2.2 051512 
* http\URI regex fixed

## 1.2.1 051412 
* Added unittest generate_output function
* Removed unittest\Output assertion_pass, assertion_fail, assertion_skip functions
* Added unittest\Output assertion function
* Added unittest\Output send_linebreak function
* unittest\Event now logs a history of assertions and results

## 1.1.0 050912 
* Added clean, delete_signal and erase_signal_history API functions.

## 1.0.0 050912 
* The engine will now clean it's storage because it likes to be tidy
* Added unit_test signal library
* Routine function now must return a 3 node array to simply checking signals
* added prggmr\prggmr API function
* added signal_interupt function to engine
* handle_loader now allows only strings|integers
* handle_loader auto removes itself after loading
* Added prggmr\Event::get_handle, set_handle functions
* handle_loader works properly
* Disallow changing the signal of an event within a handle.
* Moved the complex signals into a deeper namespacing scheme
* Added the prggmr\signal\http\Request signal.
* All API functions now fall into the prggmr namespace.

## 0.3.1.1 041012 
* Added the composer.json file
* prggmr bin now supports the -p, --passthru option

## 0.3.1 041012 
* The engine now generates and stores an event concurrently for recurring 
  complex signals.
* Event properties reference themselves correctly.
* Read*Only event properties now throw a LogicException if written to.

## 0.3.0 04032012 
* Added the engine_code utility function
* All methods use the underscore seperator for words
* Events now contain a history of all signals they have represented
* Events now contain a reference to a parent if signal within another event
* Engine now stores a running history of events that have taken place
* Event::isChild, signals, addSignal, parent methods added
* Added Engine::history method
* Removed handle post/pre execution functions
* Removed handle identifier
* Renamed \prggmr\signal\Regex to \prggmr\signal\Query
* Added \prggmr\signal\Standard abstract class
* Removed SignalInterface
* Removed chains entirely
* Event properties can now be set as read*only
* \prggmr\signal\Complex::evaluate, routine abstract method added
* \prggmr\signal\Complex is now abstract
* Added \prggmr\Engine::_searchComplex
* \prggmr\Engine::queue renamed to \prggmr\Engine::sigHandler
* \prggmr\Engine::queue now uses binary searching for finding queues
* \prggmr\Engine::queue now returns an array
* \prggmr\Engine::queue params changed to ($signal, $type)
* Regex and ArrayContains now extend \prggmr\Signal\Complex
* Moved \prggmr\SignalInterface to \prggmr\signal\SignalInterface
* Added \prggmr\signal\Complex class
* Queue uses Storage trait
* Added bin_search function
* Added Storage trait
* Queue can now be set as min or max upon construction
* Added constants QUEUE_MIN_HEAP, QUEUE_MAX_HEAP
* The State class is now a Trait
* PHP 5.4 is now required
* AUTHORS is now CREDITS
* Added \prggmr\engine\Signal::GLOBAL_EXCEPTION and GLOBAL_ERROR constants.
* Added signal_exceptions and signal_errors functions
* Queue no longer requires a Handle object for enqueue
* Added Queue::offsetSet, offsetUnset methods
* A Queue will now throw a OverflowException if QUEUE_MAX_SIZE is exceeded
* Added QUEUE_MAX_SIZE constant
* Added get_milliseconds function
* Added utils.php file
* Removed Engine::getMilliseconds method
* Added Queue::_data property and Queue::getRepresentation method
* Removed Queue::getSignal method, Queue::_signal property
* Engine::canIndex has been moved into the Signal::canIndex.
* Removed Engine::canIndex method.
* Added Handle::__invoke magic method, this throws a BadMethodCallException
  to disallow directly invoking a handle and requiring use of execute.
* Added Event::__unset, __get, __set and __isset magic methods.
* Removed Event::getData, Event::setData methods.
* Event now uses overloading for setting and getting any data.
* Removed Event::halt, Event::isHalted methods and Event::_halt property
* ArrayContainsSignal can now be set to strict mode on construction
* Removed ArrayContainsSignalStrict class
* Event now extends State class
* Engine now extends State class
* Improved LOG formatting
* Removed Event::state_message property
* Removed Event::getStateMessage, Event::setStateMessage
* Added Engine properties active_signal, active_handle
* Events no longer carry a reference to the signal or handle in 
  execution.
* Added state constants (DECLARED, RUNNING, EXITED, ERROR, RECYCLED, HALTED)
* Removed Event states (ACTIVE, ERRROR, INACTIVE)
* \prggmr\engine\Signals::HANDLE_EXCEPTION signal is signaled when an Exception
  is encountered during Handle execution.
* \prggmr\engine\Signals class added
* Engine::_fire renamed to Engine::_execute
* Signal::delChain renamed to Signal::removeChain
* Handle::fire renamed to Handle::execute
* Queue::_prioritize now calls flush.
* Modified doc block comments.
* Subscriptions are now refereed to as handles.
* Added prggmr\handle\Time class.
* Subscription class renamed to Handle.
* once api function renamed to handle_once.
* fire api function renamed to signal.
* subscribe api function renamed to handle.

## 0.2.2 01112012 
* Fixed a bug causing a Fatal Error when the Event was removed from the arguments.
  within a Subscription, this now throws a RuntimeException when encountered.
* Added signals/ directory all files are included automatically.
* Regex Signal was removed from signals.php file.
* API functions now have the ability to be replaced before loading the API.
* prggmrd bin file renamed to prggmr

## 0.2.1 12192011 
* Subscription Exceptions contain the file/line and message of the exception.
* Event::getData now returns null instead of false if the data does not exist.
* Timeouts and intervals can now be set to start at a pre determined time
* Added PRGGMR_EVENTED_ERRORS constant which allows enabling prggmr's evented
  exceptions.
* Added prggmr::EXCEPTION constant used for prggmr's evented exceptions.
* Added PRGGMRUNIT_MASTERMIND constant.
* Prggmr is now defined as prggmr (lowercase).
* Subscriptions now throw a SubscriptionException if an error is encountered.
* Multiple Signals can now be triggered upon a single fire
* added the prggmrd bin file
* timeout/interval set methods now return the subscription
* Moved SignalInterface and RegexSignal into the signal.php file ... each class
  was very small and it keeps the lib a little tidier.
* Added pre and post fire events to subscriptions
* Returned event data is now added to the event data as the "return" key.
* Errors encountered in daemon mode first try to remove timer then queue signal
  subscription
* clearInterval now returns false if a interval isnt cleared

## 0.2.0 07092011 
* Added PRGGMR_DEBUG constant
* Added the "getSignal()" method to Event which returns the Event Signal object
* Added a key parameter to Event::getData to allow for direct data access
* Fixed a bug in the Queue which caused errors when using E_STRICT @alkavan
* Subcription fires are now handled via an internal engine fire
  which is used for both timed and subscribed events.
* Added countTimers method to Engine
* Added shutdown method to Engine
* Added Engine daemon mode which allows an engine to run as a daemon
* Added Engine states (RUNNING, ERROR, DAEMON)
* Added getState method to Engine
* Added setInterval, setTimeout, clearInterval, clearTimeout methods to Engine
* Removed Adapter and AdapterInterface
* Added chain, dechain, once API functions
* Engine*>subscribe() param list changed to signal, subscription, identifier,
  priority, chain, exhaust.
* Signal*>getChain() now returns an array or null
* Event*>getChain() now returns an array or null
* Chains are now stored as array to allow for unlimited chains within a signal
* Prggmr class added
* Engine no longer implements a singleton
* Added Server class
* Engine now removes exhausted events.
* Added subscription exhaustion.

## 0.1.2 06212011 
* Engine no longer uses an SplObjectStorage for queue storage
* Added _indexStorage and _storage arrays to engine, these are used for queue
  storage

## 0.1.1 05302011 
* Added the SignalInterface interface
* Added the Signal object
* Added the Subscription object
* Added the Queue object
* Removed benchmark utility
* Removed data object
* Removed functions file
* Removed the autoloaders
* Removed all logic code from adapter, adapter now acts only as an interface to
  the engine.
* Renamed Listenable class to Adapter
* Adapter implements new Engine api
* AdapterInterface implements new Engine api
* Engine object is now a singleton
* Engine object rewritten
* Queue and Engine now use a SplObjectStorage rather than an array
* Event object no longer supplies the event chain, rather is supplied a chained
  event
* Event chains are now added through a signal
* Signal object added
* Queue object added implemented as a SplObjectStorage with priority in a queue
  (LIFO) by default
* bubble method renamed to fire
* prggmr object renamed to engine
* All Unittests rewritten
* Event is no longer a child of Adapter
* RegexSignal object added which supports event naming of "hello/:world" and any
  regex string
* New api implemented (fire, subscribe) removed benchmark, bubble

## 0.1.0 03092011
* Inital Release

## 0.0.0 11112010
* It begins
