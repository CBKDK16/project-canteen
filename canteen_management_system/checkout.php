<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
$email = $name = $address = $repassword =$number = $password = $user_type = '';
$error = [];


if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = $_POST['address'];
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
         //validate name
         if(requireValidation($_POST,'name'))
         {
            $name = $_POST['name'];
         }
         else
         {
            $error['name'] = 'Enter name';
         }

         //validate table no
         if(requireValidation($_POST,'tableNo'))
         {
            $tableNo = $_POST['tableNo'];
         }
         else
         {
            $error['tableNo'] = 'Enter table no.';
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


      //validate number
         if(requireValidation($_POST,'number'))
         {
            $number = $_POST['number'];
            if(!preg_match("/^([0-9]{10})$/",$number)){
               $error['number'] = "Invalid phone number.";
            }
            if($number < 0)
               $error['number'] = "Invalid phone number.
            ";
         }
         else
         {
            $error['number'] = 'Phone number is required.';
         }

         //validate address
         if(requireValidation($_POST,'address'))
         {
            $address = $_POST['address'];
         }
         else
         {
            $error['address'] = 'Enter House No.';
         }

         

         $total_products = implode(', ',$cart_products);

         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
         
         if(count($error) == 0)
         {
            echo '<br/>'.$user_id.'<br/>'.$tableNo.'<br/>'.$name.'<br/>'.$number.'<br/>'.$email.'<br/>'.$method.'<br/>'.$address.'<br/>'.$total_products.'<br/>'.$cart_total.'<br/>'.$placed_on;

            mysqli_query($conn, "INSERT INTO `orders`(user_id,table_no, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id','$tableNo', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $message[] = 'order placed successfully!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            header('location:orders.php');
         }
         else
         {
            $message[]  = "Please Fill up required fields.";
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo 'Rs.'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>Rs.<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Table No :</span>
            <input type="number" min="1" name="tableNo"  placeholder="enter table no." value="<?php echo $tableNo?>"/>
         <?php echo "<p class = 'error'>" .displayError($error,'tableNo'). "</p  >";?>
         </div>
         <div class="inputBox">
            <span>Your name :</span>
            <input type="text" name="name"  placeholder="enter your name" value="<?php echo $name?>"/>
         <?php echo "<p class = 'error'>" .displayError($error,'name'). "</p  >";?>
         </div>

         <div class="inputBox">
            <span>Your number :</span>
            <input type="number" name="number"  placeholder="enter your number"value="<?php echo $number?>"/>
         <?php echo "<p class = 'error'>" .displayError($error,'number'). "</p  >";?>
         </div>

         <div class="inputBox">
            <span>Your email :</span>
            <input type="email" name="email"  placeholder="enter your email" value="<?php echo $email?>"/>
         <?php echo "<p class = 'error'>" .displayError($error,'email'). "</p  >";?>
         </div>

         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address :</span>
            <input type="text" name="address"  placeholder="e.g. thaiba" value="<?php echo $address?>">
            <?php echo "<p class = 'error'>" .displayError($error,'address'). "</p  >";?>
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>