<?php

/*
 * Config file for SQLgreyGUI
 * ==========================
 * 
 * 
 * Please take also a look at app/config/app.php and adjust it to your needs
 */

return array(
    /*
     * Databases
     */
    'databases' => array(
        /*
         * Connection settings for the SQLgrey database
         */
        'sqlgrey' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'sqlgrey',
            'username' => 'sqlgrey',
            'password' => 'sqlgrey',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '', // leave empty unless you know what you're doing
        ),
        /*
         * Database to use for users and settings
         * You need to choose beetween two (2) options and enable only the
         * corresponding array below
         *
         * 
         * Option 1
         * ========
         * Use the same database that SQLgrey uses
         */
        'application' => array(
            'prefix' => 'sg_',
        ),
        /*
         * Option 2
         * ========
         * Use a different database (on a seperate host for example)
         * 
         * This might be a good idea if you want to maintain user accounts in a
         * single place and use them with multiple SQLgreyGUI installations.
         * This way you also don't need to touch the SQLgrey database and avoid
         * possible interference with SQLgrey.
         */
        /*'application' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'sqlgrey!!',
            'username' => 'sqlgrey',
            'password' => 'sqlgrey',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => 'sg_',
        ),*/
    ),
);
