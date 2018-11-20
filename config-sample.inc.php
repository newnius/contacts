<?php

/* Mysql */
/* It is not recommended to use `root` in production environment */
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'contact');
define('DB_USER', 'db_user');
define('DB_PASSWORD', 'password');
define('DB_SHOW_ERROR', false);

/* Redis */
/* Make sure that your Redis only listens to Intranet */
define('REDIS_SCHEME', 'tcp');
define('REDIS_HOST', 'localhost');
define('REDIS_PORT', 6379);
define('REDIS_SHOW_ERROR', false);

/* Site */
define('BASE_URL', 'http://127.0.0.1'); //make absolute url for SEO and avoid hijack, no '/' at the end
define('WEB_ROOT', __DIR__);

/* Auth */
define('AUTH_CODE_TIMEOUT', 300); // 5 min
define('AUTH_TOKEN_TIMEOUT', 604800); // 7 day

/* Session */
define('ENABLE_MULTIPLE_LOGIN', true);
define('BIND_SESSION_WITH_IP', true);
define('SESSION_TIME_OUT', 1800);// 30 minutes 30*60=1800
define('ENABLE_COOKIE', true);

/* Rate Limit */
define('ENABLE_RATE_LIMIT', true);
define('RATE_LIMIT_KEY_PREFIX', 'rl');

/* Email */
define('ENABLE_EMAIL_ANTISPAM', true);
//define('MAXIMUM_EMAIL_PER_IP', 8);
define('MAXIMUM_EMAIL_PER_EMAIL', 5);//last 24 hours
define('SENDGRID_API_KEY', '');
define('EMAIL_FROM', 'service@example.com');

/* OAuth */
define('OAUTH_SITE', 'https://quickauth.newnius.com');
define('OAUTH_CLIENT_ID', '');
define('OAUTH_CLIENT_SECRET', '');