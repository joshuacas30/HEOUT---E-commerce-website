<?php
session_start();
include_once("./php/conn.php");

// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
  // User is logged in
  $username = $_SESSION['username'];
} else {
  // User is not logged in
  $username = "Guest";
}

// Check if the "Add to Cart" button is clicked
if (isset($_POST['add-to-cart'])) {
  if (isset($_SESSION['customerID'])) {


    // If the user is logged in, check if the product is already in the cart_table
    $productId = $_POST['productsID'];
    $userId = $_SESSION['customerID'];

    $selectCart = $conn->prepare("SELECT * FROM cart_tbl WHERE customerID = :customerID AND productsID = :productsID");
    $selectCart->bindParam(':customerID', $userId);
    $selectCart->bindParam(':productsID', $productId);
    $selectCart->execute();

    if ($selectCart->rowCount() > 0) {
      // Product is already in the cart, you can update quantity or take other action
      echo "<script>alert('Product already in your cart');</script>";
    } else {
      // Product is not in the cart, add it to cart_table
      $insertCart = $conn->prepare("INSERT INTO cart_tbl (customerID, productsID) VALUES (:customerID, :productsID)");
      $insertCart->bindParam(':customerID', $userId);
      $insertCart->bindParam(':productsID', $productId);
      $insertCart->execute();

      echo "<script>alert('Product added to cart');</script>";
    }

    // Move the header('location: cart.php'); here

  } else {
    // If the user is not logged in, add the product to the session variable
    $productId = $_POST['productsID'];

    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
    }

    // Check if the product is already in the session cart
    if (!in_array($productId, $_SESSION['cart'])) {
      $_SESSION['cart'][] = $productId;
      echo $message[] = 'Product added to cart!';
    } else {
      echo $message[] = 'Product is already in your cart!';
    }

    // Move the header('location: cart.php'); here

  }
}


// Fetch and display the products
$select = $conn->prepare("SELECT * FROM products");
$select->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <!-- bootstrap 5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- javacript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- css bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


  <link rel="stylesheet" href="./css/prodMen.css">
  <title>Women</title>
</head>

<body>
  <nav>
    <div class="categories">
      <!-- men -->
      <div class="dropdown">
        <button class="btn" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">MEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodMen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="#">Short</a></li>
        </ul>
      </div>
      <!-- women -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">WOMEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodWomen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="#">Short</a></li>

        </ul>
      </div>
    </div>

    <div class="logo">
      <span style="color: black;">HEOUT</span>
    </div>
    <!-- cart and account menu -->
    <div class="menu-right">
      <a href="index.php">Home</a>
      <!-- cart -->
      <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class='bx bx-cart bx-sm bx-tada-hover'></i></button>
      <!-- account -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false"><i class='bx bx-user bx-tada-hover bx-sm'></i></button>
        <ul class="dropdown-menu ">
          <span>Welcome, <?php echo $username; ?></span>
          <li> <?php if (isset($_SESSION['customerID'])) : ?>

              <a href="./php/signout.php">Logout</a>
            <?php else : ?>
          <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signinModal">
              Sign in
            </button></li>
        <?php endif; ?></li>
        <li><a href="./php/product.php"><button type="button" class="btn">
              Log in as admin
            </button></a></li>
        </ul>
      </div>

    </div>

  </nav>

  <!-- search bar -->


  <!-- fetching of products here -->
  <div class="container">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search for products in this collection" aria-label="Search" aria-describedby="button-addon2">
      <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>

    <h1>WOMEN</h1>
    <h1 class="d-flex justify-content-center">ALL PRODUCTS</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php while ($row = $select->fetch()) : ?>
        <div class="col" id="container">
          <div class="card h-100" style="background-color: rgb(242, 242, 243);">
            <img src="./php/uploads/<?php echo $row['productImage']; ?>" class="card-img-top" alt="...">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['productName']; ?></h5>
                <p class="card-text"><?php echo $row['productDesc']; ?></p>
                <p class="card-text">₱<?php echo $row['price']; ?></p>


              </div>
              <div class="footer">
                <input type="hidden" name="productsID" value="<?php echo $row['productsID']; ?>">
                <button type="submit" class="btn btn-dark" value="add-to-cart" style="width: 90%; height: 50px; border-radius: 0px; " name="add-to-cart">Add to cart</button>
              </div>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>


  <!-- hanggang dito yung php tag -->
  <!-- footer -->


  <!-- modal signup  -->
  <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1>Create an Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./php/signup.php" method="post">
          <div class="modal-body">

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
              <input type="text" name="firstname" id="firstname" class="form-control fname" placeholder="Firstname">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
              <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middlename">
            </div>
            <div class="input-group">
              <span class="input-group-text"><ion-icon name="person-outline"></ion-icon></span>
              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="call-outline"></ion-icon></span>
              <input type="number" name="contactNum" id="contactNum" class="form-control" placeholder="Contact number">
            </div>

            <div class="input-group">
              <span class="input-group-text">Address</span>
              <input type="text" name="street" id="street" class="form-control" placeholder="Building no./Street name">
              <input type="text" name="brgy" id="brgy" class="form-control" placeholder="Barangay">

            </div>

            <div class="input-group">
              <input type="text" name="city" id="city" class="form-control" placeholder="City/Municipality">
              <input type="text" name="province" id="province" class="form-control" placeholder="Province">
              <input type="number" name="postalCode" id="postalCode" class="form-control" placeholder="Postal code">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="mail-outline"></ion-icon></span>
              <input type="email" name="email" id="email" class="form-control" placeholder="Your Email">

            </div>
            <div class="input-group">
              <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Username">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
              <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" maxlength="8">
            </div>

            <label for="">Already have an account?</label>
            <button type="button" name="signup" id="signup" class="btn" data-bs-toggle="modal" data-bs-target="#signinModal">
              Sign in
            </button><br><br>


            <button type="submit" class="btn btn-dark" name="submit" id="submit">Sign Up</button>
            <button type="reset" class="btn btn-dark" name="clear">Clear</button>

          </div>
        </form>
      </div>
    </div>
  </div>
  </form>

  <!-- modal signin -->
  <div class="modal fade" id="signinModal" tabindex="-1" aria-labelledby="signinModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1>Log In</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./php/signin.php" method="post">
          <div class="modal-body">

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
              <input type="text" class="form-control" name="username" placeholder="Username">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
              <input type="password" class="form-control" name="password" placeholder="Password" maxlength="8">
            </div>
            <label for="">Doesn't have an account?</label>
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signupModal">
              Sign up
            </button><br><br>
            <button type="submit" class="btn btn-dark" id="signin" name="signin" value="sign in">Sign In</button>
            <button type="reset" class="btn btn-dark" name="clear">Clear</button>

          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- offcanvas cart -->
  <!-- Modify the existing offcanvas code -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel" style="margin-left: 25%">Recently Added Products</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <?php
      // Fetch recently added products by the user
      if (isset($_SESSION['customerID'])) {
        $userId = $_SESSION['customerID'];

        $selectCart = $conn->prepare("SELECT products.productImage, products.productName, products.price, cart_tbl.productsID
                                           FROM cart_tbl
                                           JOIN products ON cart_tbl.productsID = products.productsID
                                           WHERE cart_tbl.customerID = :customerID");
        $selectCart->bindParam(':customerID', $userId);
        $selectCart->execute();

        if ($selectCart->rowCount() > 0) {
          // Display each product in the offcanvas
          while ($row = $selectCart->fetch()) {
            echo '<div class="d-flex justify-content-between mb-3">';
            echo '<img src="./php/uploads/' . $row['productImage'] . '" alt="' . $row['productName'] . '" style="max-width: 80px; max-height: 80px;">';
            echo '<div>';
            echo '<p class="mb-0">' . $row['productName'] . '</p>';
            echo '<p class="mb-0">₱' . $row['price'] . '</p>';
            echo '</div>';
            echo '<button type="button" class="btn  btn-md" style="color: red;" onclick="removeProduct(' . $row['productsID'] . ')">Remove</button>';
            echo '</div>';
          }
        } else {
          echo '<h5>Your cart is empty</h5>';
        }
      } else {
        echo '<h5>Your cart is empty</h5>';
      }
      ?>
      <a href="cart2.php"><button type="button" class="btn btn-dark" style="width: 100%;">View Cart</button></a>

    </div>
  </div>

  <!-- Add the following script to handle the removal of products -->
  <script>
    function removeProduct(productId) {
      // You can implement the removal logic here, such as making an AJAX request to remove the product from the cart
      // For demonstration purposes, you can alert the product ID
      alert('Removing product with ID: ' + productId);
    }
  </script>

  <!-- quantity function -->

  <script src=addtocart.js></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>