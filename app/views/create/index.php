<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create Your Account</h1>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-auto">

        <form action="/create/register" method="post">
    <fieldset>
      <div class="form-group">
        <label for="username">Username</label>
        <input required type="text" class="form-control" name="username"><br/><br/>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
           <input required type="password" class="form-control" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain an uppercase, lower case and atleast 8 or more characters"><br/><br/>
      </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input required type="password" class="form-control" name="confirm_password"><br/><br/>
          </div>
            <br>

        <button type="submit" class="btn btn-primary">Register</button>
    </fieldset>
    </form> 
  </div>
</div>
    <?php require_once 'app/views/templates/footer.php' ?>
