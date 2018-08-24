<?php
/*
*   App Core class
*   Creates URL and loads core controller
*   URL format - /controller/method/params
*/
class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    // print_r($this->getUrl());
    $url = $this->getUrl();

    // Look in controllers for first value
    if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
      // Then set this file as the controller string. (Also capitalize the first letter)
      $this->currentController = ucwords($url[0]);
      // Unset the zero index
      unset($url[0]);
    }

    // Require the controller file
    require_once '../app/controllers/' . $this->currentController . '.php';

    // Instantiate the controller (the variable is now of type [Controller class])
    $this->currentController = new $this->currentController;

    // Look for second part of the URL
    if (isset($url[1])) {
      // See if method exists
      if (method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
      }
      unset($url[1]);
    }
    
    // Get the parameters if they exists, otherwise just an empty array
    $this->params = $url ? array_values($url) : [];

    // Call callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getURL() {
    if (isset($_GET['url'])) {
      // Removes the trailing forward slash
      $url = rtrim($_GET['url'], '/');
      // Sanitization
      $url = filter_var($url, FILTER_SANITIZE_URL);
      // Splits string into array
      $url = explode('/', $url);
      return $url; // It's now an array
    }
  }
}

?>