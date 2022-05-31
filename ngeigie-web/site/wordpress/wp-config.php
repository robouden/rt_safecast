<?php
define('WP_CACHE', true); // WP-Optimize Cache
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
//define('WP_CACHE', true); //Added by WP-Cache Manager
//define( 'WPCACHEHOME', '/var/www/ngeigie-web/site/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'ngeigie');
/** MySQL database username */
define('DB_USER', 'ngeigie');
/** MySQL database password */
define('DB_PASSWORD', 'nGeigie-01');
/** MySQL hostname */
define('DB_HOST', '127.0.0.1');
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
define('AUTH_KEY',         'Xj-cG$]9pPK]D0/XkEK)#TEn/#s#K9fm1=LMFW{:Cm2nRJN78DujI~S?Qd+/Vk V');
define('SECURE_AUTH_KEY',  '534b8>UXcK@|6-,N*bDj4eZNDX9!vvw[C}_&-.Ysp26$oRb+nj!S>!8B[/ZF&<XK');
define('LOGGED_IN_KEY',    'd~N+M[8[*0>;+Pc}S`J{J(.%F9=[d#3%T%e3.FdpmGj$eJbOKR^SWY-g~0ava+ps');
define('NONCE_KEY',        ',7Ptoy~( Zlqt_5lQ7y+AdrVpj75-IL+i>}Ba(IoqZ?-Uz/;Gj>&4UVRs4O+zKAs');
define('AUTH_SALT',        'M3{+n4~%0*w~X$Y}5i_65@cWyr~p;F9+|@3ei~1d~{k7/!^VY|7p1675tlr3|A;L');
define('SECURE_AUTH_SALT', 'fq>x;LluY0E+2>d s!@-jd]B4lw9z)Eq}3Ga,CWxYe4`]S)C9=w:<+w<;*9HN,c6');
define('LOGGED_IN_SALT',   't4T#t}uFpaL@9Q>{gk95Fuma7PQRx6=O^;*rZqm/HMF@oYN~p;#{V dn[A&8=5x|');
define('NONCE_SALT',       'q2B:QN#sPz^)wQC!VqQ0m(z[qxQ7S+Arkh^A6-3oW*et)i3mXle8/kY,Ac~|(^k|');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
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
define('RELOCATE', true);
define('WP_DEBUG', false);
define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME']);
define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content');
define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content');
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('WP_MEMORY_LIMIT', '64M');