<?php

class Posts extends Controller {
  public function __construct() {
    if (!isLoggedIn()) {
      redirect('users/login');
    }

    $this->postModel = $this->model('Post');
    $this->userModel = $this->model('User');
  }

  public function index() {
    // Get posts
    $posts = $this->postModel->getPosts();
    
    $data = [
      'posts' => $posts
    ];

    $this->view('posts/index', $data);
  }  

  public function add() {
    // Check for the request tiype
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize inputs
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'err_title' => '',
        'err_body' => ''
      ];

      // Validate title
      if (empty($data['title'])) {
        $data['err_title'] = 'Please enter a title!';        
      }
      if (empty($data['body'])) {
        $data['err_body'] = 'Please enter text for the post body!';
      }

      // Make sure errors are empty
      if (empty($data['err_title']) &&
          empty($data['err_body'])) {
        // Validated
        if ($this->postModel->addPost($data)) {
          flash('post_message', 'Post successfully added!');
          redirect('posts');
        } 
        else {
          die('Something went wrong (ADD POST)!');
        }
      } 
      else {
        // Load view with errors
        $this->view('posts/add', $data);
      }
    }
    else {
      $data = [
        'title' => '',
        'body' => ''
      ];
  
      $this->view('posts/add', $data);
    }    
  }

  public function edit($id) {
    // Check for the request tiype
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize inputs
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'id' => $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'err_title' => '',
        'err_body' => ''
      ];

      // Validate title
      if (empty($data['title'])) {
        $data['err_title'] = 'Please enter a title!';        
      }
      if (empty($data['body'])) {
        $data['err_body'] = 'Please enter text for the post body!';
      }

      // Make sure errors are empty
      if (empty($data['err_title']) &&
          empty($data['err_body'])) {
        // Validated
        if ($this->postModel->updatePost($data)) {
          flash('post_message', 'Post successfully updated!');
          redirect('posts');
        } 
        else {
          die('Something went wrong (ADD POST)!');
        }
      } 
      else {
        // Load view with errors
        $this->view('posts/edit', $data);
      }
    }
    else {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);
      // Check for owner of the post
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      $data = [
        'id' => $id,
        'title' => $post->title,
        'body' => $post->body
      ];
  
      $this->view('posts/edit', $data);
    }    
  }

  public function show($id) {
    $post = $this->postModel->getPostById($id);
    $user = $this->userModel->getUserById($post->user_id);
    $data = [
      'post' => $post,
      'user' => $user
    ];
    $this->view('posts/show', $data);
  }

  public function delete($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);
      
      // Check for owner of the post
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      if ($this->postModel->deletePost($id)) {
        flash('post_message', 'Post removed.');
        redirect('posts');
      }
      else {
        die('Something went wrong!');
      }
    }
    else {
      redirect('posts');
    }
  }
}

?>