<?php

// Post Model class
class Post {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function getPosts() {
    $this->db->query(
      "SELECT *,
      posts.id as postId,
      users.id as userId,
      posts.created_at as postCreated, 
      users.created_at as userCreated
      FROM posts
      INNER JOIN users
      ON posts.user_id = users.id
      ORDER BY posts.created_at DESC");
    $results = $this->db->resultSet();
    return $results;
  }

  public function addPost($data) {
    $this->db->query('INSERT INTO posts (title, user_id, body) VALUES(:the_title, :the_user_id, :the_body)');
    $this->db->bind(':the_title', $data['title']);
    $this->db->bind(':the_user_id', $data['user_id']);
    $this->db->bind(':the_body', $data['body']);

    return ($this->db->execute());
  }

  public function updatePost($data) {
    $this->db->query('UPDATE posts SET title = :the_title, body = :the_body WHERE id = :the_id');
    $this->db->bind(':the_id', $data['id']);
    $this->db->bind(':the_title', $data['title']);    
    $this->db->bind(':the_body', $data['body']);

    return ($this->db->execute());
  }

  public function getPostById($id) {
    $this->db->query('SELECT * FROM posts WHERE id = :the_id');
    $this->db->bind(':the_id', $id);
    
    $row = $this->db->single();

    // Check if row exists
    return $row;
  }

  public function deletePost($id) {
    $this->db->query('DELETE from posts WHERE id = :the_id');
    $this->db->bind(':the_id', $id);

    return ($this->db->execute());
  }
}

?>