<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wp21-kalaweit' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'm0n1c4po' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'mysql' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ';7B )9fPfcx4OqOF &RY@RX:! Bc.i7}FS%`?A/<s7ki&-RoG(vu&^,,f4H I%to' );
define( 'SECURE_AUTH_KEY',  '~FOZ/p(`(.7Qu2sH]f?G,kfFVepuFebI!%6CH|{R-B;I(wgpzKw[11G+kt_d?ME)' );
define( 'LOGGED_IN_KEY',    's*0`SB *}f/`V!L<kiC^*p)T|:{Z3=4?Vlq=qJ)y2I:sEtTcl_PqO1]Ay)SMAEHf' );
define( 'NONCE_KEY',        'kT@x1))83.Szi(KAa~`2+tIf.UNc{.n<61*D:9_ZjyCdyIX}m Z5CskuJv^r xQE' );
define( 'AUTH_SALT',        'pvPI_ kYvyX`{](r736RE ~}p;1F1tDR:8txH<`,RV!p=%v#R{sI)$.1U|xY.^(%' );
define( 'SECURE_AUTH_SALT', 'g.[tk$CU#-o?=-oD+hi~QD0`d%7:*wZ[A hq(/-!|V%?j.w*jiuk}SYHT)E<qepq' );
define( 'LOGGED_IN_SALT',   'a7nM :]#[I0KlK9)[s1ny+gPA/xbbIA9|#0SMl4 %%Br|KOp5~#z7[{AMRYdt{Hc' );
define( 'NONCE_SALT',       '|zn9dvhPKfS*8xhUnX/iXN_Q{J]U!y~W%rTA;3Dy.IV5@Ri4 M$3jr,,F5^~;`.z' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp21_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
