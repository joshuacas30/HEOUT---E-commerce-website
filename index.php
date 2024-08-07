<?php
include_once("./php/conn.php");

session_start();

// Check if the user is logged in
if (isset($_SESSION['customerID'])) {
  // User is logged in
  $username = $_SESSION['username'];
} else {
  // User is not logged in
  $username = "Guest";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

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
  <link rel="stylesheet" href="./css/index.css">



</head>

<body>

  <nav>

    <div class="categories">

      <!-- men -->
      <div class="dropdown">
        <button class="btn" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">MEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodMen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="prodMen.php">Shorts</a></li>

        </ul>
      </div>
      <!-- women -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">WOMEN</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="prodWomen.php">Shirt</a></li>
          <li><a class="dropdown-item" href="prodWomen.php">Short</a></li>

        </ul>
      </div>
    </div>

    <div class="logo"><span>HEOUT</span></div>

    <!-- cart and account menu -->
    <div class="menu-right">
      <a href="">Home</a>
      <!-- cart -->
      <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class='bx bx-cart bx-sm bx-tada-hover'></i></button>
      <!-- account -->
      <div class="dropdown">
        <button class="btn " type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false"><i class='bx bx-user bx-tada-hover bx-sm'></i></button>
        <ul class="dropdown-menu dropdown-menu-end">
          <span style="margin-left: 9px;">Welcome,<?php echo $username; ?></span>
          <li> <?php if (isset($_SESSION['customerID'])) : ?>

              <a href="./php/signout.php" style="margin-left: 9px;">Logout</a>
            <?php else : ?>
          <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signinModal">
              Sign in
            </button></li>
        <?php endif; ?></li>

        <li><a href="./php/userAcc.php"><button type="button" class="btn">
              My Account
            </button></a></li>

        <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#adminSigninModal">
            Log in as admin
          </button></li>
        </ul>
      </div>

    </div>

  </nav>

  <div class="landingPage">

    <div class="landing-page-content">
      <section class="tag-line hidden">
        <span>Elevate your style</span><br>
        <span>Shop the trends</span>
      </section>
      <section class="cta-buttons hidden">
        <a href="prodMen.php"><button type="button" class="btn btn-white" style="border-radius: 30px;">Shop for Men</button></a>
        <a href="prodWomen.php"><button type="button" class="btn btn-white" style="border-radius: 30px;">Shop for Women</button></a>

      </section>
    </div>
  </div>
  <main>
    <div class="new-to-collection">
      <span class="title">New to Collection</span>
      <div class="even-rows">
        <div class="container">
          <div class="product-image"><img src="./image_assets/DSC06952_530x@2x.webp" alt=""></div>
          <div class="product-name"><span>MILITIA LONGSLEEVE TEE IN ANTHRACITE/OLIVE</span></div>
        </div>
        <div class="container">
          <div class="product-image"><img src="./image_assets/IMG_9393_530x@2x.webp" alt=""></div>
          <div class="product-name"><span>ZIP TRUCKER JACKET IN MIDNIGHT PLAID</span></div>
        </div>
        <div class="container">
          <div class="product-image"><img src="./image_assets/JMP00799_530x@2x.webp" alt=""></div>
          <div class="product-name"><span>CLASSIC SNAP HOODIE IN ANTHRACITE</span></div>
        </div>
      </div>
    </div>

    <div class="featured-clothes-wrapper">
      <span class="fp-title">Featured Products</span>
      <div class="featured-clothes">
        <div class="featured-clothes-image"><img src=".//image_assets/close-up-black-man.jpg" alt=""></div>
        <div class="description">
          <span class="fc-name">Urban Hedge Hoodie</span><br><br>
          <p>Elevate your street style with the Urban Edge Hoodie. Made from premium soft fabric, this black hoodie features a bold white text design and a convenient zip-up front. Perfect for layering and casual wear.</p>

        </div>
      </div>
      <div class="featured-clothes">
        <div class="description">
          <span class="fc-name">Urban Explorer Tee</span><br><br>
          <p>Soft pink tee with a bold "never sprung" print, offering a stylish and comfortable fit. Perfect for making a statement with an effortlessly cool and edgy vibe, whether you're out on the town or hanging with friends.</p>

        </div>
        <div class="featured-clothes-image"><img src=".//image_assets/featured-product-women.jpg" alt=""></div>

      </div>
    </div>
  </main>

  <footer>
    <div class="secondary-header">
      <div class="secondary-logo">
        <span>HEOUT</span>
      </div>
      <div class="secondary-nav">
        <ul>
          <li><a href="">About us</a></li>
          <li><a href="">Contact us</a></li>
        </ul>
        <ul>
          <li><a href="">Privacy and Policy</a></li>
          <li><a href="">Payment</a></li>
        </ul>
      </div>
    </div>

    <div class="socials">
      <a href="https://www.facebook.com/profile.php?id=100004686409201"><ion-icon name="logo-facebook"></ion-icon></a>
      <ion-icon name="logo-instagram"></ion-icon>
      <ion-icon name="logo-twitter"></ion-icon>
    </div>
  </footer>

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


            <button type="submit" class="btn btn-dark" name="signup" id="signup">Sign Up</button>
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
              <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <label for="">Doesn't have an account?</label>
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signupModal">
              Sign up
            </button><br><br>
            <button type="submit" class="btn btn-dark" id="signin" name="signin" value="sign in">Sign In</button>
            <button type="reset" class="btn btn-transparent" name="clear">Clear</button>

          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- admin modal signup -->
  <!-- modal signup  -->
  <div class="modal fade" id="adminSignupModal" tabindex="-1" aria-labelledby="adminSignupModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1>Create an Admin Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./php/adminSignup.php" method="post">
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
              <input type="password" name="pass" id="pass" class="form-control" placeholder="Password">
            </div>

            <label for="">Already have an account?</label>
            <button type="button" name="signup" id="signup" class="btn" data-bs-toggle="modal" data-bs-target="#adminSigninModal">
              Sign in
            </button><br><br>


            <button type="submit" class="btn btn-dark" name="submit" id="submit">Sign Up</button>
            <button type="reset" class="btn btn-dark" name="clear">Clear</button>

          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- admin modal sign in-->
  <div class="modal fade" id="adminSigninModal" tabindex="-1" aria-labelledby="adminSigninModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1>Log In as Admin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./php/adminSignin.php" method="post">
          <div class="modal-body">

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="at-circle-outline"></ion-icon></span>
              <input type="text" class="form-control" name="username" placeholder="Username">
            </div>

            <div class="input-group">
              <span class="input-group-text"><ion-icon name="lock-closed-outline"></ion-icon></span>
              <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <label for="">Doesn't have an account?</label>
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#adminSignupModal">
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
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Recently added products</h5>
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
            echo '<button type="button" class="btn  btn-md" style="color:red;" onclick="removeProduct(' . $row['productsID'] . ')">Remove</button>';
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
  <!-- scroll magic -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js"></script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script src="app.js"></script>
  <script src="modal.js"></script>
</body>

</html>