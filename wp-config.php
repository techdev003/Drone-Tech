<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u988363620_drontech' );

/** Database username */
define( 'DB_USER', 'u988363620_drontech' );

/** Database password */
define( 'DB_PASSWORD', 'Z;0peKshHLr' );

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
define( 'AUTH_KEY',         'beYf?3;g$.so:RG#TdSn()(C`}}mu;/1?yHJje[~4?@TL-f48;c}FfV-WiQUkGI{' );
define( 'SECURE_AUTH_KEY',  'D,*x#To-|]GVw&^:azBh~]>|)bxw9B=/nVvX:=P!,b{R2x)NLY9.DylVKV2uL9G8' );
define( 'LOGGED_IN_KEY',    '*7Vl/a&L-cMtRO=HyZ$)$X.~_Q6eqnLh2W;q&o]nF+-y;I{QedoE3qb<BO.^x33&' );
define( 'NONCE_KEY',        '+/nM!`1sQt_?LTQxmT,Bfp*eonEc4eSj!KOZ$$v0F&.Efd.b~<;KvHZ0=K2|x2|K' );
define( 'AUTH_SALT',        '-WLa?-0Y4AdPj nyqgLvZZ`^zED</8k $lo~NV0WJNj<pphr;bJz@3zM;Xc.e`}*' );
define( 'SECURE_AUTH_SALT', 'khL$8,o2h^}|,UE1g[mR.2o2f${<[8:GE,jrw>b32_szW7;YdxV4LSE+5%}cE:~1' );
define( 'LOGGED_IN_SALT',   '?pz%c_(PNoH+&f=#9 pKiuiVt%p?K+,6r>aiO;K}`NBEHJ8#+;d^hE)I%~s)6>WY' );
define( 'NONCE_SALT',       'OEeEX7fE3v/qYm+Njc4HH{y-[m.6BhGS>!B3B+vyoa.3~l:7ck9DH>5CjZvye]yx' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
