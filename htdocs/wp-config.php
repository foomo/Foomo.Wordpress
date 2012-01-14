<?php
# enable logging
#error_reporting(E_ALL ^ E_DEPRECATED);

$config = \Foomo\Wordpress\Module::getWordpressConfig();

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

$moduleClassName = \Foomo\Modules\Manager::getModuleClassByName(\Foomo\Modules\Manager::getDocumentRootModule());
$moduleConfigFilename = call_user_func(array($moduleClassName, 'getHtdocsDir')) . DIRECTORY_SEPARATOR . 'wp-config.php';

# Load custom config file if exists
if (\file_exists($moduleConfigFilename)) require_once($moduleConfigFilename);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
if (!defined('AUTH_KEY')) define('AUTH_KEY', $config->security['authKey']);
if (!defined('SECURE_AUTH_KEY')) define('SECURE_AUTH_KEY', $config->security['secureAuthKey']);
if (!defined('LOGGED_IN_KEY')) define('LOGGED_IN_KEY', $config->security['loggedInKey']);
if (!defined('NONCE_KEY')) define('NONCE_KEY', $config->security['nonceKey']);
if (!defined('AUTH_SALT')) define('AUTH_SALT', $config->security['authSalt']);
if (!defined('SECURE_AUTH_SALT')) define('SECURE_AUTH_SALT', $config->security['secureAuthSalt']);
if (!defined('LOGGED_IN_SALT')) define('LOGGED_IN_SALT', $config->security['loggedInSalt']);
if (!defined('NONCE_SALT')) define('NONCE_SALT', $config->security['nonceSalt']);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
if (!defined('WPLANG')) define('WPLANG', $config->lang);

/**
 * Caching
 */
if (!defined('WP_CACHE')) define('WP_CACHE', $config->cache);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) define('WP_DEBUG', true);
if (!defined('WP_DEBUG_LOG')) define('WP_DEBUG_LOG', false);
if (!defined('WP_DEBUG_DISPLAY')) define('WP_DEBUG_DISPLAY', false);

# multisite
if (!defined('WP_ALLOW_MULTISITE')) define('WP_ALLOW_MULTISITE', $config->allowMultiSite);

#  base url
$base_url = \Foomo\Utils::getServerUrl();
$default_url = \Foomo\Utils::getServerUrl();

# site url
if (!defined('WP_HOME')) define('WP_HOME', $default_url);
if (!defined('WP_SITEURL')) define('WP_SITEURL', $base_url . call_user_func(array($moduleClassName, 'getWordpressPath')));

# content settings
if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', call_user_func(array($moduleClassName, 'getContentDir')));
if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', $base_url . call_user_func(array($moduleClassName, 'getContentPath')));

# plugin dir
if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR', call_user_func(array($moduleClassName, 'getPluginsDir')));
if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL', $base_url . call_user_func(array($moduleClassName, 'getPluginsPath')));


/* That's all, stop editing! Happy blogging. */

# Absolute path to the WordPress directory.
define('ABSPATH', \Foomo\Wordpress\Module::getWordpressDir() . '/');

# Sets up WordPress vars and included files.
require_once(ABSPATH . 'wp-settings.php');