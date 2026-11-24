<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'XPLAY-C' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'k!CU!=Km*]@B>%_?n$YxD6IJ_:l&-4gHuXrr*lg:N4(Y+e|aE3cW*8Cp(ll;ksM|' );
define( 'SECURE_AUTH_KEY',  '`Ya/8hZa1Nlh6Nqk}8/Cf .}en#Yi#}tv7G.gp*B?vCNw,L5w=PyxM 7EdN)Etrt' );
define( 'LOGGED_IN_KEY',    '+*T ?C0VteQ@ryU@Mr_~p:*^(b*9r-Hl=E0}Loxxz/wg4_Y_]43?MP&(WG%hb>J)' );
define( 'NONCE_KEY',        'GtzU;Bo8j}t<RS2Q0j(cG+nXMQ*V~_*puNdieQJ*PH{J]enzQ:O!K{P!Q6^6MVD6' );
define( 'AUTH_SALT',        '|KU+3 A~z<eZ>T83q}Q0]AScwpL:pLv@JV.Li]I/!Zikx*f{ttq,#)t#-sFX?@4I' );
define( 'SECURE_AUTH_SALT', '!q72$NH/2fWDwi6<~^A~PQ]1Sg[%%CJXpB}RLRX|l@m`kV.OaW@SqnZ0Tj!E7oP*' );
define( 'LOGGED_IN_SALT',   '[#=N+37YFHy-~GT5:$C2+/U`}F3`1&}Lye3$N:9c~Ya$a:d|]R_N-#2&o?KW47{Y' );
define( 'NONCE_SALT',       'Qps~)M@%/jXYMxg_J]~fB]2xKrwCCV_Y9mq*=)+])[FA(iUs-j8U$~X-`&<vN}3H' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
