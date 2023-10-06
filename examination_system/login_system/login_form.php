<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if the password is at least 8 characters long
    if (strlen($password) >= 8) {
        $select = "SELECT * FROM user_form WHERE email = '$email'";

        $result = mysqli_query($conn, $select);

        if ($result) {
            $row = mysqli_fetch_array($result);

            if ($row) {
                // Verify the entered password against the stored hashed password
                if (password_verify($password, $row['password'])) {
                    if ($row['user_type'] == 'admin') {
                        $_SESSION['admin_name'] = $row['name'];
                        header('location: admin_page.php');
                    } elseif ($row['user_type'] == 'user') {
                        $_SESSION['user_name'] = $row['name'];
                        $_SESSION['id'] = $row['id'];
                        header('location: select_course.php');
                    } elseif ($row['user_type'] == 'teacher') {
                        $_SESSION['teacher_name'] = $row['name'];
                        header('location: teacher_page.php');
                    }
                } else {
                    $error[] = 'Incorrect email or password!';
                }
            } else {
                $error[] = 'User not found!';
            }
        } else {
            $error[] = 'Database query error!';
        }
    } else {
        $error[] = 'Password must be at least 8 characters long!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password (at least 8 characters)">
      <select name="user_type">
         <option value="user">User</option>
         <option value="admin">Admin</option>
         <option value="teacher">Teacher</option> <!-- Add this line -->
      </select>
      <input type="submit" name="submit" value="Login now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register now</a></p>
   </form>
</div>

</body>
</html>
