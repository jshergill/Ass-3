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
}
  }
}