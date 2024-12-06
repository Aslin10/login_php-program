<?php
@include 'config.php'; // Include your database configuration

session_start();

if (isset($_POST['submit'])) {
    // Sanitize and escape user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $query = "SELECT * FROM user_register WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['email_id'] = $row['email'];
                $_SESSION['age'] = $row['age'];
                $_SESSION['job'] = $row['job'];
                $_SESSION['state'] = $row['state'];
                $_SESSION['language'] = $row['language'];
                header('Location: admin_page.php'); // Redirect to admin page
                exit();
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['email_id'] = $row['email'];
                $_SESSION['age'] = $row['age'];
                $_SESSION['job'] = $row['job'];
                $_SESSION['state'] = $row['state'];
                $_SESSION['language'] = $row['language'];

                header('Location: user_page.php'); // Redirect to user page
                exit();
            } else {
                $error = 'Invalid user type!';
            }
        } else {
            $error = 'Incorrect password!';
        }
    } else {
        $error = 'Email not found!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="form-container">
      <form action="login_form.php" method="post">
         <h3>Login</h3>
         <?php
         // Display errors if any
         if (isset($error)) {
             echo '<span class="error-msg">' . $error . '</span>';
         }
         ?>
         <label>Email:</label>
         <input type="email" name="email" required placeholder="Enter your email">
         <label>Password:</label>
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="submit" name="submit" value="Login Now" class="form-btn">
         <p>Don't have an account? <a href="register_form.php">Register now</a></p>
      </form>
   </div>
</body>
</html>
