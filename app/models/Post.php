<?php

namespace Aries\Dbmodel\Models;

use Aries\Dbmodel\Includes\Database;


class Post extends Database {
    private $db;

    public function __construct() {
        parent::__construct(); // Call the parent constructor to establish the connection
        $this->db = $this->getConnection(); // Get the connection instance
    }

    public function getPosts() {
        $sql = "SELECT posts.title, posts.content, posts.author_id, users.first_name, users.last_name, posts.date_posted
                FROM posts 
                JOIN users ON posts.author_id = users.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function getPostsByLoggedInUser($id) {
        $sql = "SELECT posts.title, posts.content, posts.author_id, users.first_name, users.last_name, posts.date_posted
                FROM posts 
                JOIN users ON posts.author_id = users.id
                WHERE posts.author_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addPost() {
        $sql = "INSERT INTO posts (title, content, author_id, date_posted) VALUES (:title, :content, :author_id, :date_posted)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'author_id' => $_POST['author_id'],
            'date_posted' => date('Y-m-d H:i:s')
        ]);
        
        header('Location: index.php');
        exit;
    }

    public function update($data) {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
        return "Record UPDATED successfully";
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        return "Record DELETED successfully";
    }   
}
