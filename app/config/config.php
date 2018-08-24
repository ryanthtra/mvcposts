<?php
// WARNING: Exclude the DB params from your repository!
// SUGGESTION: Make a copy of this file and call it config.secret.php.  It will be git-ignored.

// Holds some constants and their values.

// DB params
define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
define('URLROOT', 'http://localhost/mvcposts');

// Site name
define('SITENAME', 'MVC Posts');

// Version number
define('APPVERSION', '1.0.0');

?>