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
    if (isset($_SESSION['failAuth']) && $_SESSION['failAuth'] >= 3) {
        $elapsed = time() - ($_SESSION['FailTime'] ?? 0);

        if ($elapsed < 60) {
            $remaining = 60 - $elapsed;
            $_SESSION['error'] = "Too many attempts. Try again in {$remaining} seconds.";
            header('Location: /login');
            exit;
        } else {
            $_SESSION['failAuth'] = 0;
            unset($_SESSION['FailTime']);
        }
    }
     $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
      $statement->bindValue(':name', $username);
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
     if ($rows && password_verify($password, $rows['password'])) {
              $_SESSION['auth'] = 1;
              $_SESSION['username'] = ucwords($username);
              $_SESSION['success'] = "Welcome, " . ucwords($username) . "!";
              unset($_SESSION['failAuth'], $_SESSION['FailTime']);
              $this->loginattempt($username, 'success');
              header('Location: /home');
              exit;
          } else {
              $_SESSION['failAuth'] = ($_SESSION['failAuth'] ?? 0) + 1;
              $_SESSION['FailTime'] = time();

              $_SESSION['error'] = "Invalid username or password.";
              $this->loginattempt($username, 'fail'); 
              header('Location: /login');
              exit;
          }
   }
  private function loginattempt($username, $status) {
      $db = db_connect();
      $stmt = $db->prepare("INSERT INTO logins (username, attempt) VALUES (:username, :attempt)");
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':attempt', $status === 'success' ? 1 : 0);
      $stmt->execute();
  }
  public function register($username, $password) {
  $db = db_connect();

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