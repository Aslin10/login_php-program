<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['email_id'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['age'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['job'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['state'])){
   header('location:login_form.php');
}
if(!isset($_SESSION['language'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
   
      <h3>User Profile</h3>
      <p>Name: <span><?php echo $_SESSION['user_name'] ?></span></p>
      <p>Email id: <span><?php echo $_SESSION['email_id'] ?></span></p>
      <p>Age: <span><?php echo $_SESSION['age'] ?></span></p>
      <p>Job-title: <span><?php echo $_SESSION['job'] ?></span></p>
      <p>State: <span><?php echo $_SESSION['state'] ?></span></p>
      <p>Language: <span><?php echo $_SESSION['language'] ?></span></p>
      <p>this is an user page</p>
      <a href="login_form.php" class="btn">login</a>
      <a href="register_form.php" class="btn">register</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>