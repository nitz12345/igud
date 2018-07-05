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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'igudhg2q_wp-22476-730290' );

/** MySQL database username */
define( 'DB_USER', 'igudhg2q_wp0290' );

/** MySQL database password */
define( 'DB_PASSWORD', 'TCYHxdPQ' );

/** MySQL hostname */
define( 'DB_HOST', 'localdb' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Q^VjDv+K.Z3sM@RD(*u*9Avw7YEdllgHN!D&xxI(Fb}84_#k?,:vXLH#?B,b35$P');
define('SECURE_AUTH_KEY',  '>PBS4-CwmMFiS`No6DYH@&tHSj6S_Q;2+XsMTK^e>n,;)m/-dnmZQ-C~pEuDvl2U');
define('LOGGED_IN_KEY',    'JWS5h(i4Ja_-/0pJieqE+-)L6sLsUVV&)#uo6fP.!{5heski|Wu2N#D36;<BF|kz');
define('NONCE_KEY',        '%z+F~DZx~s.vu|y)obNfsdsrU9.|f_l8K{#LG)^lV,:FX.TH^,YEpwYO.4EI+w5o');
define('AUTH_SALT',        'FfjLCXu-WUj~[cs[Vd5-lA+w,C,fI||5P1#oh6]HSa,CeBkK:*`+7Z_e!q@gs B;');
define('SECURE_AUTH_SALT', '(JM/+CS4tl5-D]IFhD dW[/t-V422LIVp/~+1?@X#/-#I;m=]N)Hu0-XDaxO@ii`');
define('LOGGED_IN_SALT',   '?mE{.h*FN!5t).J@}LOqmLa}g*sUgaCPsh{ev_3E=F/-uj1ENbRY.;oDd9y{M :+');
define('NONCE_SALT',       'I`>CXYs_MBKEivd+d2y_7;$/rx-0:$)K.b!klt)~0gJ|hj6gXW#>qbkK#C|_#)u3');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'oaj_';


define('WP_DEBUG',false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
