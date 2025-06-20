<?php

class Create extends Controller {

    public function index() {		
	    $this->view('create/index');
    }
  public function register() {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = trim($_POST['username']);
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match.";
                header('Location: /create');
                exit;
            }

            $user = $this->model('User');
            try {
                $user->register($username, $password);
                $_SESSION['success'] = "Account created successfully.";
                header('Location: /login');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = "Something went wrong.";
                header('Location: /create');
                exit;
            }
        }
    }
}