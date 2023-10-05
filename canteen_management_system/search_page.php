<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

    $itemId = $_POST['itemId'];
   $itemName = $_POST['itemName'];
   $image = $_POST['image'];
   $salePrice = $_POST['salePrice'];
   $quantity = $_POST['quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$itemName' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(itemId,user_id, name, price, quantity, image) VALUES('$itemId','$user_id', '$itemName', '$salePrice', '$quantity', '$image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>search page</h3>
   <p> <a href="home.php">home</a> / search </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="search products..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>

<section class="items_div" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_items = mysqli_query($conn, "SELECT * FROM `addItem` WHERE itemName LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_items) > 0){
         while($item = mysqli_fetch_assoc($select_items)){
   ?>
   <form action="" method="post" id="items">
                                <div id="" class="item">
                                    <div class="front">
                                        <div class="price">
                                            RS.<?php echo $item['salePrice']; ?>/- 
                                        </div>
                                        <div class="front-img">
                                            <img src="uploaded_img/<?php echo $item['image']; ?>"/>
                                        </div>
                                        <div>
                                            <h3><?php echo $item['itemName'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="back">
                                        <h3><?php echo $item['itemName'] ?></h3>
                                        <div class="back-img">
                                            <img src="uploaded_img/<?php echo $item['image']; ?>"/>
                                        </div>
                                        <div class="desc">
                                            <p>
                                                <?php echo $item['itemDesc'] ?>
                                            </p>
                                        </div>


                                          <input type="number" min="1" name="quantity" value="1" class="qty">
                                          <input type="hidden" name="itemId" value="<?php echo $item['itemId']; ?>">
                                          <input type="hidden" name="itemName" value="<?php echo $item['itemName']; ?>">
                                          <input type="hidden" name="salePrice" value="<?php echo $item['salePrice']; ?>">
                                          <input type="hidden" name="image" value="<?php echo $item['image']; ?>">


                                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                                    </div>
                                </div> 
                              </form>
   <?php
            }
         }else{
            echo '<p class="empty">no result found!</p>';
         }
      }else{
         echo '<p class="empty">search something!</p>';
      }
   ?>
   </div>
  

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>