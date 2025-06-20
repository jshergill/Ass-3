<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
        
    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

   public function authenticate($username, $password) {
    $username = strtolower($username);
    $db = db_connect();

    // SESSION LOCKOUT LOGIC
    if (isset($_SESSION['failAuth']) && $_SESSION['failAuth'] >= 3) {
        $elapsed = time() - ($_SESSION['lastFailTime'] ?? 0);

        if ($elapsed < 60) {
            $remaining = 60 - $elapsed;
            $_SESSION['error'] = "Too many login attempts. Try again in {$remaining} seconds.";
            header('Location: /login');
            exit;
        } else {
            // Lockout expired
            $_SESSION['failAuth'] = 0;
            unset($_SESSION['lastFailTime']);
        }
    }
   }
  public function register($username, $password) {
  $db = db_connect();

  // Check if user exists
  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindValue(':username', strtolower($username));
  $stmt->execute();
  if ($stmt->fetch()) {
      die('Username already taken.');
  }
    $hashed = password_hash($password, PASSWORD_DEFAULT);
     $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
     $stmt->bindValue(':username', strtolower($username));
     $stmt->bindValue(':password', $hashed);
     $stmt->execute();
}
}