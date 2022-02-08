<?php

$appRoot = dirname(__DIR__);

require $appRoot . '/var/settings/db.inc.php';

defined('CONFIG_DIR') || define('CONFIG_DIR', $appRoot . '/config');
defined('LOG_DIR')    || define('LOG_DIR',    $appRoot . '/var/logs');
defined('VENDOR_DIR') || define('VENDOR_DIR', $appRoot . '/vendor');

defined('GEMS_TIMEZONE') || define('GEMS_TIMEZONE', 'Europe/Amsterdam');

/**
 * Always set the system timezone!
 */
date_default_timezone_set(GEMS_TIMEZONE);

require_once VENDOR_DIR . '/gemstracker/cloverlistener/run.php';