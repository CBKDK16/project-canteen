<?php
include 'config.php';
try{
      $sql_admin = "select name from admin_tbl";
      $result = mysqli_query($conn,$sql_admin);
      $username_admin_db = [];
      if(mysqli_num_rows($result)>0)
      {
         while ($row = mysqli_fetch_assoc($result)) {
            array_push($username_admin_db,$row);
         }
      }

      $sql_admin = "select name from users";
      $result = mysqli_query($conn,$sql_admin);
      $username_user_db = [];
      if(mysqli_num_rows($result)>0)
      {
         while ($row = mysqli_fetch_assoc($result)) {
            array_push($username_user_db,$row);
         }
      }

   }
   catch(Exception $e) 
   {

   }

$email = $username =$repass = $pass = '';
$error = [];


if(isset($_POST['submit'])){

   //validate username  
   if(requireValidation($_POST,'username'))
      {
         $username = mysqli_real_escape_string($conn, $_POST['username']);
         $ulength = strlen($username);
         if($ulength<8)
         {
            $error['username'] = 'username should be minimum 8 character.';
         }
         else
         {
            foreach($username_admin_db as $key => $user)
            {
               if($user['name'] == $username)
               {
                  $error['username'] = "Username already taken";
               }
            }

            foreach($username_user_db as $key => $user)
            {
               if($user['name'] == $username)
               {
                  $error['username'] = "Username already taken";
               }
            }
         }
      }
      else
      {
         $error['username'] = 'Username is required';
      }


      //validate email
      if(requireValidation($_POST,'email'))
      {
         $email = mysqli_real_escape_string($conn, $_POST['email']);
         if(!preg_match("/^[\w.+\-]+@gmail\.com$/",$email))
         {
            $error['email'] = "Email in proper format.";
         }
      }
      else
      {
         $error['email'] = 'Enter email';
      }

   
   
   

   //validate password
      if(requireValidation($_POST,'password'))
      {
         $pass = mysqli_real_escape_string($conn, $_POST['password']);
         if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@*#$%]{8,12}$/',$pass))
         {
            $error['password'] = "Password don't meet requiement!";
         }
      }
      else
      {
         $error['password'] = 'Password is required';
      }

      //validate cpass
      if(requireValidation($_POST,'cpassword'))
      {
         $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
         if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@*#$%]{8,15}$/',$cpass))
         {
            $error['cpassword'] = "Password don't meet requiement!";
         }
      }
      else
      {
         $error['cpassword'] = 'Password is required';
      }

     if(count($error) == 0)
     {
      

      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){
         $message[] = 'user already exist!'; 
      }

       if($pass != $cpass){
         $error['password'] = 'password not matched!';
         $error['cpassword'] = 'password not matched!';
      }else{
            mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$username', '$email', md5('".$cpass."'))") or die('query failed');
            $message[] = 'registered successfully!';
            header('location:login.php');

      }
     }
     else
      {
         $message[]  = "Please Fill up required fields.";
      }  
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container"> 
 
   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="username" placeholder="enter your username"  class="box" value="<?php echo $username?>"/>
         <?php echo "<p class = 'error'>" .displayError($error,'username'). "</p  >";?> 

      <input type="email" name="email" placeholder="enter your email eg:. name1@gmail.com"  class="box" value="<?php echo $email?>"/>
         <?php echo "<p class = 'error'>" . displayError($error,'email'). "</p>";?>
    

      <input type="password" name="password" placeholder="enter your password"  class="box" />
         <?php echo "<p class = 'error'>" . displayError($error,'password'). "</p>";?>

      <input type="password" name="cpassword" placeholder="confirm your password"  class="box" />
         <?php echo "<p class = 'error'>" . displayError($error,'cpassword'). "</p>";?>


      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>
      
      