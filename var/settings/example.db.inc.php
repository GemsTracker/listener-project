<?php

define ('HOST', 'localhost');
define ('USER', 'testuser');
define ('PASSWD', 'testpwd');
define ('DATABASE', 'testdb');

// HL7 Stettings
define('HL7_IP', '127.0.0.1');
define('HL7_ORGANIZATION', 72);
define('HL7_PORT', 23887);

// define('LOG_LISTENER', 'hl7_listener.log');
// define('LOG_QUEUE',    'hl7_queue.log');


// define('GTIMPORT_EXEC_CMD', 'php -f "D:\\GemsTracker\\Cleft\\htdocs\\index.php" -- ');

//-------------------------------------------------------------------------------------------------
// Optional environmental settings for your project
//-------------------------------------------------------------------------------------------------
defined('APPLICATION_ENV') || define('APPLICATION_ENV',  'development');
