<?php

class User {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  // Find user by email
  public function findUserByEmail($email) {
    $this->db->query('SELECT * FROM users WHERE email = :the_email');
    $this->db->bind(':the_email', $email);
    
    $row = $this->db->single();

    // Check if row exists
    return ($this->db->rowCount() > 0);
  }

  // Find user by email
  public function getUserById($id) {
    $this->db->query('SELECT * FROM users WHERE id = :the_id');
    $this->db->bind(':the_id', $id);
    
    $row = $this->db->single();

    // Check if row exists
    return $row;
  }

  // Register new user
  public function register($data) {
    $this->db->query('INSERT INTO users (name, email, password) VALUES(:the_name, :the_email, :the_password)');
    $this->db->bind(':the_name', $data['name']);
    $this->db->bind(':the_email', $data['email']);
    $this->db->bind(':the_password', $data['password']);

    return ($this->db->execute());
  }

  // Login user
  public function login($email, $password) {
    $this->db->query('SELECT * FROM users WHERE email = :the_email');
    $this->db->bind(':the_email', $email);

    $row = $this->db->single();

    $hashed_pw = $row->password;
    if (password_verify($password, $hashed_pw)) {
      return $row;
    }
    else {
      return false;
    }
  }
}

?>