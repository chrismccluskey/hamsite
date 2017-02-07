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
define('DB_NAME', 'hamsite');

/** MySQL database username */
define('DB_USER', 'hamsite');

/** MySQL database password */
define('DB_PASSWORD', 'hamsite');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         'vP&Ugy8DHko,eY3N${eOTtxRtXeq(<WpqjBEt]~!gx&ui$.:lGguB0zI<KoVA2Tp');
define('SECURE_AUTH_KEY',  'Q]fD6_oqSQQ[H3~<|QF%*r@b1|[v>Y1i81(_h=Ir zms ;#h=r;>~Y|13;PNgcy]');
define('LOGGED_IN_KEY',    'k{r,tATf6OS-FLy,a86VcOPg8%8m`~nj_:k&):0&(f|1}VQ_JHYFilq(M4]F9N&}');
define('NONCE_KEY',        'Y(|B:$;MNj3i,I|7pWVsWf]>E>2cReQ@n|1A2O#[:JBu(_+!lc4)MhKoGU}eA<pt');
define('AUTH_SALT',        '~V/l7cRC|T[,4!t?^Zn9a64mk8wbIyV4_lg(Ur{FcVnrq2]/*sUm9>o7S-Xpuhzy');
define('SECURE_AUTH_SALT', '*YdR]^<f4ay&2`M:>[>>>Ob7cukByFG*J ;Pe*Vy%H|OKs2Z4wVqFfrMdLI06rsq');
define('LOGGED_IN_SALT',   '%W~M~zQB5jerUfwa8%sJknvHAilf:4;v?}Whpumixw)2|f1$$?/r}u7T_T}dXk0u');
define('NONCE_SALT',       '<.5`*d^jq$?Vbt8|=>J|:Y~:+qj0G>/epW&8.Yv?#o_A7+$$RGB?u>-!9e$kJML)');

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
