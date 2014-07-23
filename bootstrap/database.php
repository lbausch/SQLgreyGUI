<?php

$db_settings = require __DIR__ . '/../config.php';

Config::set('database.default', 'application');
Config::set('database.connections.sqlgrey', $db_settings['databases']['sqlgrey']);

$db_array_keys = array_keys($db_settings['databases']['application']);

// check if the application should use the same database as SQLgrey
if (count($db_array_keys) === 1 && @$db_array_keys[0] == 'prefix') {
    Config::set('database.connections.application', $db_settings['databases']['sqlgrey']);
    Config::set('database.connections.application.prefix', $db_settings['databases']['application']['prefix']);
} else {
    Config::set('database.connections.application', $db_settings['databases']['application']);
}