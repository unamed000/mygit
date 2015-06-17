<?php
/**
 * Load the networking and time modules.
 */
load_module('network');
load_module('time');

// Create a new network connection
$connection = network\connect('0.0.0.0', ['port' => 1337]);

// Failsafe awake signal
$awake = new time\SIG_Awake(45, TIME_SECONDS);

// When a connection is received perform the following
// * Check the client device type
// * If request device check if video connected and emit requested signal
// * If video device set as video device in server
$connection->on_client(function($client, $server){
    // Read in the giving data from connected client
    $client = json_parse($client->data);
    // Check the client type
    // For devices that communicate in
    if ($client->type === DEVICE_REQUEST) {
        // Check and error back to device if no video device
        if ($server->device_video) {
            $client->write("{error: 'Video device not connected';}");
            $client->disconnect();
        }
        // Check command from device
        if ($data->start) {
            emit(new SIG_Video_Device_Start(), $server->device_video);
            // Failsafe to shutdown the device 45 seconds after connecting
            if (is_exhausted($awake)) {
                time\awake(45, function() use ($server){
                    signal(
                        new SIG_Video_Device_Stop(),
                        $server->device_video
                    );
                }, TIME_SECONDS);
            }
        }
        if ($data->stop) {
            emit(new SIG_Video_Device_Stop(), $server->device_video);
        }
        $client->disconnect();
        return;
    }
    // Video device we send signals
    if ($client.type === DEVICE_VIDEO) {
        $server->device_video = $client;
    }
    return;
});

/**
 * Process the video device start signal
 */
signal(new SIG_Video_Device_Start(), non_exhaust(function($device){
    $device->write(write_video_cmd(false, true));
}));

/**
 * Process the video device stop signal
 */
signal(new SIG_Video_Device_Stop(), non_exhaust(function($device){
    $device->write(write_video_cmd(false, true));
});

/**
 * Prepares a JSON message to send the video device
 */
function write_video_cmd($start = false, $stop = false)
{
    $obj = new stdClass();
    $obj->start = $start;
    $obj->stop = $stop;
    return json_encode($obj);
}