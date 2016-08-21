<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'vorobiova');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'aztek');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
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
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');

