<?php
import('time');
import('ftp');

$connection = [
    'hostname' => '-',
    'username' => '-',
    'password' => '-'
];

$files = [
    dirname(realpath(__FILE__)).'/file_1.txt',
    dirname(realpath(__FILE__)).'/file_2.txt',
    dirname(realpath(__FILE__)).'/file_3.txt',
    dirname(realpath(__FILE__)).'/file_4.txt'
];

$uploader = ftp\upload($files, $connection, function(){
    echo "Upload Started".PHP_EOL;
});

ftp\complete($uploader, null_exhaust(function(){
    echo $this->get_file()->get_name() . ' uploaded succesfully'.PHP_EOL;
}));

ftp\failure($uploader, null_exhaust(function(){
    echo $this->get_file()->get_name() . ' failed to upload'.PHP_EOL;
}));