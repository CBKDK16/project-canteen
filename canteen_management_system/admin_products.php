<?php

include 'config.php';


session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};


//initalizing value of var into null
   $itemName = $itemDesc = $itemKeywords = $image = $sPrice = $quantity = '';
   $error = [];

if(isset($_POST['add_items'])){

   
   // $name = mysqli_real_escape_string($conn, $_POST['name']);
   // $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   //validate item name
      if(requireValidation($_POST,'itemName'))
      {
         $itemName = $_POST['itemName'];
      }
      else
      {
         $error['itemName'] = 'Enter Item Name';
      }

      //validate item description
      if(requireValidation($_POST,'itemDesc'))
      {
         $itemDesc = $_POST['itemDesc'];
      }
      else
      {
         $error['itemDesc'] = 'Enter Item desc';
      }

      // //validate image
      // if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
      // {
      //    $img_name = $_FILES['image']['name'];
      //    $img_size = $_FILES['image']['size'];
      //    $tmp_name = $_FILES['image']['tmp_name'];
      //    $err = $_FILES['image']['error'];

      //    //error check
      //    if($err == 0)
      //    {
      //       if($img_size<2000000)
      //       {
      //          $img_ex = pathinfo($img_name,PATHINFO_EXTENSION);
      //          $img_ex_lc = strtolower($img_ex);

      //          $allowed_exs = array("jpg","jpeg","png");

      //          if(in_array($img_ex_lc,$allowed_exs)){
      //             $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc;
      //             $img_upload_path = 'uploaded_img/'.$new_img_name;
      //             move_uploaded_file($tmp_name,$img_upload_path);
      //          }
      //          else{
      //             $error['image'] = "You can't upload files of this type.";
      //          }

      //       }
      //       else{
      //          $error['image'] = "Sorry, your file is too large.";
      //       }
      //    }
      //    else{
      //       $error['image'] = "unknown error occurred!";
      //    }
      // }
      // else
      // {
      //    $error['image'] = 'Choose image';
      // }

      $itemKeywords = $_POST['itemKeywords'];

      $sPrice = $_POST['sPrice'];
      $quantity = $_POST['quantity'];
   if(count($error) == 0)
   {   
      $select_item_name = mysqli_query($conn, "SELECT itemName FROM `addItem` WHERE itemName = '$itemName'") or die('query failed');

      if(mysqli_num_rows($select_item_name) > 0){
         $message[] = 'item name already added';
      }
      else{
         $add_item_query = mysqli_query($conn, "insert into addItem(itemName,itemDesc,itemKeywords,image,salePrice,quantity)values('$itemName','$itemDesc','$itemKeywords','$image','$sPrice','$quantity')") or die('query failed');

         if($add_item_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'item added successfully!';
         }
      }else{
         $message[] = 'item could not be added!';
      }
         
      }
   }
}


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Items</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css?v=<?php echo time();?>">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">
   <div class="keywords_desc">
      <h3 class="keyword_title">Keywords Lists</h3>
      <p>
         Carbohydrate <br/>
         Fats <br/>
         Sugar <br/>
         Nutritious<br/>
         Proteins<br/>
         Fermented foods<br/>
         Calories<br/>
         Fatty fish<br/>
      </p>
      <h4>Types of Emotions</h4>
      <p>
         Happy<br/>
         Sad<br/>
         Anger<br/>
         Excitement<br/>
      </p>
      <h4></h4>
      <p>
         Hot<br/>
         Cold<br/>
      </p>
   </div>
   <div>
      <h1 class="title">Food Items</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <h3>add Items</h3>

         <!-- <input type="text" name="name" class="box" placeholder="enter product name" required>
         <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required> -->

         <div>
            <input type="text" name="itemName" placeholder="Item Name" class="box"/>
         </div>
         <div>
            <input type="text" name="itemDesc" placeholder="Item Description" class="box"/>
         </div>
         <div>
            <input type="text" name="itemKeywords" placeholder="Keywords i.e happy, fat, spicy and so on." class="box"/>
         </div> 
         <div>
              <input type="file" placeholder="Image" 
              accept="image/jpg, image/jpeg, image/png" name="image" class="box" />
              <?php echo displayError($error,'image');?>
         </div>

         <div>
            <input type="number" placeholder="Sale Price" name="sPrice" class="box"/>
         </div>
         <div>
            <input type="number" placeholder="Quantity" name="quantity" class="box"/>
         </div>

         <input type="submit" value="add items" name="add_items" class="btn">
      </form>

   </div>

   <div class="keywords_desc">
      <h3 class="keyword_title">Keywords Lists</h3>
      <p>
         Magnesium <br/>
         Vegatables<br/>
      </p>
      <p>   
         Non-veg<br/>
         Veg<br/>
      </p>
      
   </div>
</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_items = mysqli_query($conn, "SELECT * FROM `addItem`") or die('query failed');
         if(mysqli_num_rows($select_items) > 0){
            while($fetch_items = mysqli_fetch_assoc($select_items)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_items['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_items['itemName']; ?></div>
         <div class="price">Rs.<?php echo $fetch_items['salePrice']; ?>/-</div>
         <a href="admin_products.php?update=<?php echo $fetch_items['itemId']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_items['itemId']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>