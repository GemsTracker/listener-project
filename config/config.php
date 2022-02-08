<?php

return [
    /* Application configuration */
    'application' => [
        'ip'       => HL7_IP, // gethostbyname(gethostname()), // The ip address of this machine
        'port'     => HL7_PORT,                        // The port it will listen on
        'logfile'  => defined('LOG_LISTENER') ? LOG_DIR . '/' . LOG_LISTENER : null,
        ],
    'cleanup'       => [
        'logfile'  => defined('LOG_CLEANUP') ? LOG_DIR . '/' . LOG_CLEANUP : null,
    ],
    /*  Database connector */
    'database'    => [
        'driver'   => 'Mysqli',
        'database' => DATABASE,
        'username' => USER,
        'password' => PASSWD,
        'charset'  => 'utf8',
        'hostname' => HOST
        ],
    'project'     => [
        'name'     => 'UmcuListener',
        ],
    'queue'       => [
        'logfile'  => defined('LOG_QUEUE') ? LOG_DIR . '/' . LOG_QUEUE : null,
        ],
];
