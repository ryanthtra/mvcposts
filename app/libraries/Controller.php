<?php

/*
*   Base Controller
*   loads models and views
*/
class Controller {
  // Loads the model
  public function model($model) {
    // Require model file
    require_once '../app/models/' . $model . '.php';

    // Instantiate model
    return new $model();
  }

  // Loads the view
  // Data for putting into the view
  public function view($view, $data = []) {
    // Look for view
    if (file_exists('../app/views/' . $view . '.php')) {
      // Require model file
      require_once '../app/views/' . $view . '.php';
    }
    else {
      // View doesn't exist
      die('View does NOT exist!');
    }
  }

  public function index() {
    $data = [
      'title' => 'Default Index Page'
    ];
    $this->view('default/index', $data);
  }
}

?>