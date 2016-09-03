<?php 
/* Constants */
define('APP_LOCATION', '/development/mongodb-crud-with-authentication-using-php/'); /* Change this to your development path */
define('DOMAIN', $_SERVER['HTTP_HOST'] . APP_LOCATION);
define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . APP_LOCATION); 
define('SITE_URL', 'http://' . DOMAIN . APP_LOCATION);
define('UPLOADS_URL', 'http://' . DOMAIN . '/img/uploads/');
define('UPLOADS_DIR', DOMAIN . '/img/uploads/');