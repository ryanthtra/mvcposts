<?php
// Load config file
require_once 'config/config.secret.php';

// Load helpers
require_once 'helpers/url_helpers.php';
require_once 'helpers/session_helper.php';

// Loading libraries
// require_once 'libraries/Core.php';
// require_once 'libraries/Controller.php';
// require_once 'libraries/Database.php';

// Autoloading libraries (replaces the three above)
spl_autoload_register(function($className){
  require_once 'libraries/' . $className . '.php';
})

?>