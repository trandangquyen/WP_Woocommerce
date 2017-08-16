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
define('DB_NAME', 'wordpress_ecom');

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
define('AUTH_KEY',         'SNK.AO4j_/0+$&vE&L`3J,PrR%i@1B.46N(dp[31ogk[vmwJ`Nbd4y8ULqy ?B&a');
define('SECURE_AUTH_KEY',  'L6[xIHX*~ZV5,Gq{JkoZ.*Kz_BENOJ(m,A}C/vpXiCrLYYRIerD6G~AV_D[*1_^b');
define('LOGGED_IN_KEY',    'r2]1:-Mx4jtK>Nuz/)NTy.Y= 35TPlq-w5y;T3=P[ax_]3q_eBc{N0!piRwxa@p6');
define('NONCE_KEY',        'aH,Qw1Ldw-4O/tI#Q#?mK>&*5u@8^Y?H@S+nipY4V+W{cJYL4ugOgVXB%~zxm;hv');
define('AUTH_SALT',        '+3(}K yKDJ}vY,QfE7N$-gGk]#e+*QY.  c|Z[wUeox2kDe|O99|BH4+qgS!|iyU');
define('SECURE_AUTH_SALT', '0@NCQ+UBAlAX=nhxkFhL1x:$2=U& 2mn7UL=>q$XJcp#aZV$Zy!<w5|7D!.?gA`4');
define('LOGGED_IN_SALT',   'lYn&zZJ)fsl@dzdic0~I~a<&~zsMjrX{+Ur50xgfo2E](AF]~0^fkH0 m2]!{{g-');
define('NONCE_SALT',       '@>%N@RpY?9s!,mC+D-sQ6:z+VmRk[4(JtH0,1e[tI(#E/@pRrTN xAqt6oE,W-0,');

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
