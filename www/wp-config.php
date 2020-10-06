<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pmb');

/** MySQL database username */
define('DB_USER', 'pmb');

/** MySQL database password */
define('DB_PASSWORD', 'Password01');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '17ntmPLRuPVS&@NrciSxN`dGxC.&A$JseH:_-K]W)h.M4KF&}?HS 6e%lXW${@%A');
define('SECURE_AUTH_KEY',  'RTgm><Sc(M^HavVu|h/0y(f|4Yc`{iM@FjJ9~DBB%&a|E.bE5KPis;}/-5(2,m~.');
define('LOGGED_IN_KEY',    'z& CF0=SIb@;u$a7#`^-5-@T_3F^]=}.LPA]M;Z%c3)w1kM@c+e2VoRl{$McOtDf');
define('NONCE_KEY',        'PwSBF6E>5?wSz{Q*_:Y5+Ek(,Lv#%w _(SU!N_D,0.3nH|vQ`ou|kDF2fwmnlUTs');
define('AUTH_SALT',        'u-5/jA>zNASG+tX6 }iLhgIg^?-;`EE|]$zw|2=+5)~/(6LcJ>WYb+|[fVm+9WdU');
define('SECURE_AUTH_SALT', ')S1u3L1-Qw2Y`Te@HZooCYz0%s3|zqIV v(Ew({A)M3- I(:9ms#im-*AO}w@APf');
define('LOGGED_IN_SALT',   'k+3==`^^s;oQ_4~ob=kE:L=Hkxno1N)-wA{sA-FN-RJ?#C|jDY0|:FYmwk4Pem4 ');
define('NONCE_SALT',       'U/Y/IN5v0d^FOE+[.WhwPrqG;-Mo<=7#><`4$o+lMIm7Ra%qO.xc{Cd[p**x;yPr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pmb_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Settings for PMB
 */
define("WP_MEMORY_LIMIT", 128);
define('DISALLOW_FILE_EDIT', true);
