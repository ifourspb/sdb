<?php
/**
 * �������� ��������� WordPress.
 *
 * ������ ��� �������� wp-config.php ���������� ���� ���� � ��������
 * ���������. ������������� ������������ ���-���������, �����
 * ����������� ���� � "wp-config.php" � ��������� �������� �������.
 *
 * ���� ���� �������� ��������� ���������:
 *
 * * ��������� MySQL
 * * ��������� �����
 * * ������� ������ ���� ������
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** ��������� MySQL: ��� ���������� ����� �������� � ������ �������-���������� ** //
/** ��� ���� ������ ��� WordPress */
define('DB_NAME', 'vorobiova');

/** ��� ������������ MySQL */
define('DB_USER', 'root');

/** ������ � ���� ������ MySQL */
define('DB_PASSWORD', 'aztek');

/** ��� ������� MySQL */
define('DB_HOST', 'localhost');

/** ��������� ���� ������ ��� �������� ������. */
define('DB_CHARSET', 'utf8');

/** ����� �������������. �� �������, ���� �� �������. */
define('DB_COLLATE', '');

/**#@+
 * ���������� ����� � ���� ��� ��������������.
 *
 * ������� �������� ������ ��������� �� ���������� �����.
 * ����� ������������� �� � ������� {@link https://api.wordpress.org/secret-key/1.1/salt/ ������� ������ �� WordPress.org}
 * ����� �������� ��, ����� ������� ������������ ����� cookies �����������������. ������������� ����������� �������������� �����.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'oyWSPm<B>*J#BOx<oN^;B|)K7;oxy{q!~KUXggRZG}uL$[8X:fJ()RSGN?|,k7^k');
define('SECURE_AUTH_KEY',  '6V[3k+GC5n<l@NK/Hy3%>1n<db|Wz{{-iQo|)(%tP;*7YgF9zj$>JwN9r2}[tv>V');
define('LOGGED_IN_KEY',    'M+ iD:xgL0vqQ5bDe*+[v;X-me_*ux/CKYOuz1L9eRaeoP&c94,Lnudv*e8c<yr-');
define('NONCE_KEY',        '}Dv3WlB_PtHYkJ*-WbTbPZAWZf}]hSME.Px~&8,@F-hzL9IFJPIE?Ra-B,BhjhE<');
define('AUTH_SALT',        '41pm{%[c&b_pZKDrt.D-Z~-z;U052x+Lb!b7l:gP~b1vLO&{9_AT xmQHnj$,~H3');
define('SECURE_AUTH_SALT', 'ukNe$v.TO{xOK/7zB;^N|0!d,q wIo|Vc%xi2.n)XJ:]i<Wv.C2;Vd+j[8ae@hB[');
define('LOGGED_IN_SALT',   'pch7X3|4cLni<Q&?Zh8srnqg[Yw^3Vt.1cL|3$ce{&%+=PqZna@m|&-Qf#{`Tvy<');
define('NONCE_SALT',       'M]r9b_Wh]n:Xf]= jPDW{DO8Q[|k#$#m`59Q?0W{`TG+FH~crfiC[p|y<dmczhR|');

/**#@-*/

/**
 * ������� ������ � ���� ������ WordPress.
 *
 * ����� ���������� ��������� ������ � ���� ���� ������, ���� ������������
 * ������ ��������. ����������, ���������� ������ �����, ����� � ���� �������������.
 */
$table_prefix  = 'wp_';

/**
 * ��� �������������: ����� ������� WordPress.
 *
 * �������� ��� �������� �� true, ����� �������� ����������� ����������� ��� ����������.
 * ������������� �������� � ��� ������������ ������������� ������������ WP_DEBUG
 * � ��ϣ� ������� ���������.
 * 
 * ���������� � ������ ���������� ���������� ����� ����� � �������.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* ��� �ӣ, ������ �� �����������. �������! */

/** ���������� ���� � ���������� WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** �������������� ���������� WordPress � ���������� �����. */
require_once(ABSPATH . 'wp-settings.php');

