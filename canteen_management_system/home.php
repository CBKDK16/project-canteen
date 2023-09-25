<?php

include 'config.php';
include 'function/cosine_similarity.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

//database connection
    $connection = mysqli_connect('localhost','root','','canteen_db');   
    if(isset($_POST['btnCompare']))
    {
        print_r($_POST);
        // Retrieve documents from the form
        $document1 = $_POST['document1'];

        //default keywords
        $keyword = 'hlo,happy,sad,fat,oil,carb,good';

        //tokenize the comma text into indiviuals words
        $keywords = explode(',',strtolower($keyword));

        //data from database
            $items = [];
            $cosineSimilaritys = [];
            $select = "SELECT * FROM additem";
            $result = mysqli_query($connection,$select);
                        
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

        

    }


// if(isset($_POST['add_to_cart'])){

//    $product_name = $_POST['product_name'];
//    $product_price = $_POST['product_price'];
//    $product_image = $_POST['product_image'];
//    $product_quantity = $_POST['product_quantity'];

//    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//    if(mysqli_num_rows($check_cart_numbers) > 0){
//       $message[] = 'already added to cart!';
//    }else{
//       mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
//       $message[] = 'product added to cart!';
//    }

// }

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
                <textarea id="document1" name="document1" required placeholder="Please input Item Description !!!" id = "textarea"></textarea><br>
            </div>
            <input type="submit" value="Click Me" name="btnCompare" id="btn" >

        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/popup.js"></script>
</section>

<section class="products">
   <div class="box-container">
         <h1 class="title">Items for You</h1>

         <?php  
               if(isset($items_after_remove_zero))
                {
                    foreach($items_after_remove_zero as $key => $value)
                    {
                        $id = $key;
                        foreach($items as $key => $item)
                        {
                            if($id == $item['itemId'])
                            { ?>
                               
                              <form action="" method="post" class="box">
                                <div id="" class="item">
                                    <div class="front">
                                        <div class="front-img">
                                            <img src="img/bowl.jpeg"/>
                                        </div>
                                        <div>
                                            <h3><?php echo $item['itemName'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="back">
                                        <h3><?php echo $item['itemName'] ?></h3>
                                        <p><?php echo $item['itemDesc'] ?></p>
                                    </div>
                                </div> 
                              </form>
                        <?php    }
                        }

                    }
                }
         
         ?>


   </div>
</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>




<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>