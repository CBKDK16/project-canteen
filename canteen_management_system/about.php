<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/lunchroom.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
            <p>At our canteen , we take pride in offering you a seamless and satisfying dining experience. Here's why you should choose us for your culinary needs:

            Diverse Menu,

            Convenience,

            Quality Ingredients,
            Affordability,

            Speedy Delivery,
            Customer Satisfaction and so on.
         </p>
         <p>
            Choose our canteen for a delightful culinary journey, where convenience, taste, and affordability come together to create an exceptional dining experience.
         </p>

      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>