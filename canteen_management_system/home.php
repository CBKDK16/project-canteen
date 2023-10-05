<?php

include 'config.php';
include 'function/cosine_similarity.php';
session_start();

$user_id = $_SESSION['user_id']; 

if(!isset($user_id)){
   header('location:login.php');
}
//data from database
            $items = [];
            $cosineSimilaritys = [];
            $select = "SELECT * FROM additem";
            $result = mysqli_query($conn,$select);
                        
            if(mysqli_num_rows($result)>0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    array_push($items,$row);
                }
            }
            else{
               echo '<p class="empty">no products added yet!</p>';
            } 


            $compare_data = [];
            $select = "SELECT * FROM compare_tbl";
            $result = mysqli_query($conn,$select);
                        
            if(mysqli_num_rows($result)>0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    array_push($compare_data,$row);
                }
            }
  
    if(isset($_POST['btnCompare']))
    {
        // Retrieve documents from the form
        $document1 = $_POST['document1'];

        //default keywords
        $keyword = 'hlo,happy,sad,anger,Sugar,Nutritious,spicy,protein,drink,vegetable,hot,cold,fat,oil,carb,good,calorie,fats,veg,nonveg';

        //tokenize the comma text into indiviuals words
        $keywords = explode(',',strtolower($keyword));

        
            // echo '<br/><br/>data from database';
            // print_r($items);  


        //tokenize the comma text into indiviuals words
        foreach($items as $key => $item) {
            $items_keywords = explode(',',strtolower($item['itemKeywords']));
            $itemId = $item['itemId'];

            $item_keywords_trim = [];
            foreach($items_keywords as $w)
            {
                $ftext = preg_replace("/[^a-zA-Z0-9\s]/", "", trim($w));
                array_push($item_keywords_trim,$ftext);

            }

            // echo '<br/> items_keywords  from database  '; 
            // print_r($item_keywords_trim);
     
            // Preprocess the text
            $preprocessedText = preprocess($document1);
            // echo "<br/><pre> preprocessedText from user   ";
            // print_r($preprocessedText);

            // echo "<br/><pre> keywords (default keywords) ";
            // print_r($keywords);

            //compare two array values and find there intersect(similar word in array)
            $words = array_intersect($preprocessedText, $keywords);
            
            // echo "<br/><pre> words after comparing user and default keywords  ";
            // print_r($words);

            // Compute term frequency (TF) vectors
            $tfVector1 = computeTF($words);
            $tfVector2 = computeTF($item_keywords_trim);

            // print_r($tfVector1);
            // print_r($tfVector2);

            // Compute cosine similarity
            $cosineSimilarity = computeCosineSimilarity($tfVector1, $tfVector2);
            $cosineSimilaritys = array_push_assoc($cosineSimilaritys, $itemId, $cosineSimilarity);

            // echo '<br/> <br/> cosineSimilaritys   <br/>';
            
            // print_r($cosineSimilaritys);

            // echo ' <br/> end of loop <br/>   <br/><br/>   <br/>  <br/>';
            
        }
        // print_r($cosineSimilaritys);
        arsort($cosineSimilaritys);
        // print_r($cosineSimilaritys);

        $items_after_sort = [];
        $items_after_remove_zero = [];

        //removing zero value from cosine similarity calculation 
        foreach($cosineSimilaritys as $key => $value)
        {
            $id = $key;
            $value = $value;


            // echo ' <br/> id    ' . $id;

            // echo ' <br/> value    ' . $value;

            if($value != 0)
            {
                $items_after_remove_zero = array_push_assoc($items_after_remove_zero, $id, $value);
            }        
        }
        // print_r($items_after_remove_zero);
        // echo '<pre>';
        // print_r($compare_data);
        // echo '</pre>';
        foreach($items_after_remove_zero as $key => $value)
        {
            $id = $key;
            if($compare_data != null)
            {
                //  
            }
            else
            {
                $check_cart_numbers = mysqli_query($conn, "INSERT INTO  `compare_tbl`(item_id)VALUES('$id')") or die('query failed');
            }
            
        }   

    }
    
    if(isset($items_after_remove_zero)==null)
    {
        $data = [];
        $compare_data = mysqli_query($conn, "SELECT * FROM `compare_tbl`");
        if(mysqli_num_rows($compare_data)>0)
        {
            while($row = mysqli_fetch_assoc($compare_data)){
                array_push($data, $row); 
            }
        }
    }

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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Custom Selected food items Arriving At Your table</h3>
      <p>Simplify your food items shopping with our online system that lets you explore, choose, and receive food items from the comfort of your table.</p>
   </div>

</section>

<section id="popup_section">
   <div class="popup" id="popup">
        <button id="close">&times;</button>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?> ">
            <div>
                <label for="document1" id="inputfromuser">Item description</label>
            </div>
            
            <div>
                <textarea id="document1" name="document1" placeholder="Please input Item Description !!!" id = "textarea"></textarea><br>
            </div>
            <input type="submit" value="Click Me" name="btnCompare" id="btn" >

        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/popup.js"></script>
</section>

<section class="items_div">
   
            
         <?php  
               if(isset($items_after_remove_zero) != 0)
                {?>
                <h1 class="title">Items for You</h1>
                    <div class="box-container">
                        <?php
                    foreach($items_after_remove_zero as $key => $value)
                    {
                        $id = $key;
                        foreach($items as $key => $item)
                        {
                            if($id == $item['itemId'])
                            { ?>
                               
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
                        <?php    }
                        }

                    }?>
                     </div>
                    <?php
                }
         
         ?>


         <?php  
               if(isset($data)>0 && $data != null)
                {?>
                <h1 class="title">Items for You </h1>
                    <div class="box-container">
                        <?php
                    foreach($data as $key => $value)
                    {
                        $id = $value['item_id'];
                        foreach($items as $key => $item)
                        {
                            if($id == $item['itemId'])
                            { ?>
                               
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
                        <?php    }
                        }

                    }?>
                     </div>
                    <?php
                }
         
         ?>


  
</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/lunchroom.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>we take pride in offering you a seamless and satisfying dining experience.</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>




<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>