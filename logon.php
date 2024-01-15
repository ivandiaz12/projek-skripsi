
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Halaman Login</title> 
    <link href="assets/css/logon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
<?php if($_POST) include 'aksi.php'; ?>
            <div class="wrapper">
        <div class="title"><span>Login Form</span></div>
        
        <form method="post">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="user" name="user" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" id="inputPassword" name="pass" placeholder="Password" required>
          </div>
          
          <div class="row button">
            <input type="submit" >
          </div>
      
        </form>
      </div>
    </div>
  </body>
</html>
