<?php

$config = Foomo\Wordpress\Module::getConfig();

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $config->database['name']);

/** MySQL database username */
define('DB_USER', $config->database['username']);

/** MySQL database password */
define('DB_PASSWORD', $config->database['password']);

/** MySQL hostname */
define('DB_HOST', $config->database['host']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', $config->database['charset']);

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', $config->database['collate']);


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = $config->database['prefix'];

require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-config.php');

/* That's all, stop editing! Happy blogging. */

# Absolute path to the WordPress directory.
if ( !defined('ABSPATH') ) define('ABSPATH', \Foomo\Wordpress\Module::getWordpressDir());

# Sets up WordPress vars and included files.
require_once(ABSPATH . 'wp-settings.php');