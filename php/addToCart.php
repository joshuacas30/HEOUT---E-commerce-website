<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:login.php');
};



if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="home-page-style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>

   
<div class="container">
<header>
     <nav>
        <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <img class="menu" src="./img/icons8-menu-50.png" alt="menu">
            </label>
            <label class="logo"><a href="index.php"><img class="mulana" src="./img/MULANA-removebg-preview.png" alt="picture"></a></label>
            <ul>
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shopping.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
            
            <ol class="imgs">
            <li><form action="search.php" method="post">
                <input type="text" id="search" placeholder="search here..." name="search">
            </form></li>
            <li><a href="shopping.php"><img class="people" src="./img/grocery-store.png" alt=""></a></li>

            <li><a href="profile.php"><img class="people" src="./img/people.png" alt=""></a></li>

            <li><a href="logout.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn"><img class="people" src="./img/icons8-logout-30.png" alt="out" title="log out"></a></li>
                

            </ol>
  </nav>
     </header>


<div class="products">

   <h1 class="heading">latest products</h1>

   <div class="box-container">

   <?php
      $select_product = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_product)){
   ?>
      <form method="post" class="box" action="">
         <img class="product-image" src="<?php echo $fetch_product['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">₱<?php echo $fetch_product['price']; ?></div>
         <input type="number" min="1" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
   <?php
      };
   };
   ?>

   </div>

</div>

</div>

</body>

</html>