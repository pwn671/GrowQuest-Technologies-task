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
define( 'DB_NAME', 'wordtask-filtering-users' );

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
define( 'AUTH_KEY',         '}M^YkT?Vx^!L)bOd/GP,8RI,.sA1t]H9MZ]@ER=vZ,#*En8jr[XuJ`HwijYNI6:8' );
define( 'SECURE_AUTH_KEY',  ';w(%y?T@LHy]k:OgZE}.s00DZK}nw;m/R?@gR| [w&9%QmXGzcX/8wMs/MiTNjg5' );
define( 'LOGGED_IN_KEY',    '+2!SX&L #&/_|&9vV$;_Z2I?}E@fl#+8HT}BU+JMJuFi`-TX2gM=MOaQ([KKOVLi' );
define( 'NONCE_KEY',        ']rAo]#{=Grr|]/1&w9ke/9qyjR%PxKG( oeB,hxvL8-q[nI{nx/Lj(zuM[T;)/TT' );
define( 'AUTH_SALT',        '!:3 na<K^Ll?L)G`5+4L03*Ze%/e2[xzJ7=@GJiOwy1)xoIR8#AR_1c_zvP;VQP ' );
define( 'SECURE_AUTH_SALT', '&QppH.^emBSN5 v^Hg%h9F1I[>X7tGTz={uhhDG&BQb&@QQb>y#H^lW^(q))nk+o' );
define( 'LOGGED_IN_SALT',   '$gB)Tt2Q-5eEJ;f&De=(Kg[&#uUF_+,gt F8R%!}pTKxuTlX9}rsQ)RIvp.+[vw!' );
define( 'NONCE_SALT',       '3gEv:v375dYSOi9`qNkOtr?Pw;FR)jn)ZTl#Cm1N#,n5}Tw+c1=yL@W2BJ|%~p#B' );

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
