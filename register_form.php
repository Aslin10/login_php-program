<?php
@include 'config.php'; // Include database configuration

if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    
    $age = htmlspecialchars($_POST['age']);
    $job = htmlspecialchars($_POST['job']);
    $state = htmlspecialchars($_POST['state']);
    $language = htmlspecialchars($_POST['language']);
    $user_type = htmlspecialchars($_POST['user_type']);
    $error = []; // Initialize error array

    // Check if user already exists
    $query = "SELECT * FROM user_register WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists with this email!';
    } else {
        if ($password !== $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user
            $insert_query = "INSERT INTO user_register (name, email, password,age,job,state,language, user_type) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
            $insert_stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "sssissss", $name, $email, $hashed_password, $age, $job, $state, $language, $user_type);

            if (mysqli_stmt_execute($insert_stmt)) {
                header('Location: login_form.php'); // Redirect to login page on success
                exit();
            } else {
                $error[] = 'Failed to register user. Please try again!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>
   <link rel="stylesheet" href="css/style.css"> <!-- Link to your custom CSS -->
</head>
<body>
   <div class="form-container">
      <form action="register_form.php" method="post">
         <h3>Register Now</h3>
         
         <?php
         if (!empty($error)) {
             foreach ($error as $err) {
                 echo '<span class="error-msg">' . $err . '</span>';
             }
         }
         ?>

         <input type="text" name="name" required placeholder="Enter your name">
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="password" name="cpassword" required placeholder="Confirm your password">
        
         <input type="number" name="age" required placeholder="Enter your Age">
         <input type="text" name="job" required placeholder="Enter your job">
         <input type="text" name="state" required placeholder="Enter your State">
         <input type="text" name="language" required placeholder="Enter your Language">
         <select name="user_type" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
         </select>
         <input type="submit" name="submit" value="Register Now" class="form-btn">
         <p>Already have an account? <a href="login_form.php">Login now</a></p>
      </form>
   </div>
</body>
</html>
