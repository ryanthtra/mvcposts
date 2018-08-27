<?php

class Users extends Controller {
  public function __construct() {
    $this->userModel = $this->model('User');
  }

  // Both POST and GET
  public function register() {
    // Check for POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process the inputs in the form
      // Sanitization
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'password2' => trim($_POST['password2']),
        'err_name' => '',
        'err_email' => '',
        'err_password' => '',
        'err_password2' => ''
      ];

      // Validate email
      if (empty($data['email'])) {
        $data['err_email'] = "Please enter email!";
      }
      else {
        // Check if email not in database
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['err_email'] = "Email is already registered!";
        }
      }

      // Validate name
      if (empty($data['name'])) {
        $data['err_name'] = "Please enter name!";
      }

      // Validate password
      if (empty($data['password'])) {
        $data['err_password'] = "Please enter password!";
      }
      elseif(strlen($data['password']) < 6) {
        $data['err_password'] = "Password must be at least 6 characters!";
      }

      // Validate confirm password
      if (empty($data['password2'])) {
        $data['err_password2'] = "Please confirm password!";
      }
      else {
        if ($data['password'] != $data['password2']) {
          $data['err_password2'] = "Passwords do not match!";
        }
      }
      
      // Make sure errors are empty
      if (empty($data['err_email']) &&
          empty($data['err_name']) &&
          empty($data['err_password']) &&
          empty($data['err_password2'])) {
        // All valid entries
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register user
        if ($this->userModel->register($data)) {
          flash('register_success', 'You are registered and can log in!');
          // Redirect
          redirect('users/login');
        }
        else {
          die("Something went wrong!");
        }
      }
      else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    }
    else {
      // GET request, so just load the form
      // Init data
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password2' => '',
        'err_name' => '',
        'err_email' => '',
        'err_password' => '',
        'err_password2' => ''
      ];
      
      $this->view('users/register', $data);
    }
  }

  // Both POST and GET
  public function login() {
    // Check for POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process the inputs in the form
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'err_email' => '',
        'err_password' => ''
      ];

      // Validate email
      if (empty($data['email'])) {
        $data['err_email'] = "Please enter email!";
      }

      // Validate password
      if (empty($data['password'])) {
        $data['err_password'] = "Please enter password!";
      }

      // Check for user/email
      if ($this->userModel->findUserByEmail($data['email'])) {
        // User found
      }
      else {
        $data['err_email'] = 'Incorrect email!';
      }

      // Make sure errors are empty
      if (empty($data['err_email']) &&          
          empty($data['err_password'])) {
        // All valid entries
        // Check and set logged in user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
          // Create session
          $this->createUserSession($loggedInUser);
        }
        else {
          $data['err_password'] = 'Incorrect password!';
          $this->view('users/login', $data);
        }
      }
      else {
        // Load view with errors
        $this->view('users/login', $data);
      }
    }
    else {
      // GET request, so just load the form
      // Init data
      $data = [
        'email' => '',
        'password' => '',
        'err_email' => '',
        'err_password' => ''
      ];
      
      $this->view('users/login', $data);
    }
  }

  public function createUserSession($user) {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('posts/index');
  }

  public function logout() {
    unset($_SESSSION['user_id']);
    unset($_SESSSION['user_email']);
    unset($_SESSSION['user_name']);
    session_destroy();
    redirect('users/login');
  }
}

?>