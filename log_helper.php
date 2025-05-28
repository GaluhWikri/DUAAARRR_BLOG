<?php

function log_activity($message) {
    $logfile = 'activity.log';
    $time = date('Y-m-d H:i:s');
    $entry = "[$time] [INFO] $message" . PHP_EOL;

    file_put_contents($logfile, $entry, FILE_APPEND | LOCK_EX);
}

function log_error($message) {
    $logfile = 'error.log';
    $time = date('Y-m-d H:i:s');
    $entry = "[$time] [ERROR] $message" . PHP_EOL;

    file_put_contents($logfile, $entry, FILE_APPEND | LOCK_EX);
}