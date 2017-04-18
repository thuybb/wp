<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'z~(:p.i .=~JUkn]$]UC|Oj@Q?KF(aB6T^=+Xpg[5=s]bnzh$Ccuuf],Wpb`3ZnX');
define('SECURE_AUTH_KEY',  ',5ZTy^^a(MIn; :S@vvlXuq[Tz&Bj5o,uTZB7A,hHbu!Mzr@OSbA|wAF1xx+E3.X');
define('LOGGED_IN_KEY',    '&k)d/ZyWSg><{x;g<3kJ^a],_U_Z]jKf+M Lo$:!qpH&?9{-=H,V`n4}WSs03Qsh');
define('NONCE_KEY',        'F$T2)PQqFSqd74GCiQ&X0ZH:WFj$ =!ft/^9uFkF[x9/>lVvqzS>vZy}mQVy0Y[!');
define('AUTH_SALT',        'U;r`6HSzr0h|`-bvDM&=_b(w+W6{_`Z,Z+cD^d&A=:zKAbqkl<eYt9 ,Hu>L?2qK');
define('SECURE_AUTH_SALT', 'Rav}Evw8{ X}y2,o}Pi:V *3cJ`~`gFDx9lXU}<6bhKCi**A4D#LtG)%;laX&V_d');
define('LOGGED_IN_SALT',   'G`ND1VJ_q `+D4=R~}BwR |*Q?>61`,2kasZ^gzV0eoqoo;qJVy61GO}vN`RuW52');
define('NONCE_SALT',       'vrFaaf(~ayn`^}|cr)Pn0.vO_;fS#1:(Uct~@qVXVVuUhud<JU|w>)eM+B; e%3s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
