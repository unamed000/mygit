<?php
$sig = SIG('foo');
// Emit a few foo objects
for($i=0;$i<5;$i++){
    emit($sig);
}
$emitted = 0;
foreach(signal_history() as $_node) {
    if ($_node[0] instanceof $sig) {
        $emitted++;
    }
}
echo $emitted;