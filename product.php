<?php
session_start();
include_once("./php/conn.php");

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
            echo $message[] = 'Product is already in your cart!';
        } else {
            // Product is not in the cart, add it to cart_table
            $insertCart = $conn->prepare("INSERT INTO cart_tbl (customerID, productsID) VALUES (:customerID, :productsID)");
            $insertCart->bindParam(':customerID', $userId);
            $insertCart->bindParam(':productsID', $productId);
            $insertCart->execute();

            echo $message[] = 'Product added to cart!';
        }

        header('location: cart2.php');
        exit();
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

        header('location: product.php');
        exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search for products in this collection" aria-label="Search" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
        </div>
        
        <h1>MEN</h1>
        <h1 class="d-flex justify-content-center">SHIRT</h1>
        
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php while($row = $select->fetch()): ?>
                <div class="col" id="container">
                    <div class="card h-100">
                        <img src="./php/uploads/<?php echo $row['productImage']; ?>" class="card-img-top" alt="...">
                        <form action="" method="post" enctype="multipart/form-data">  
                            <div class="card-body">
                                <h5 class="card-title">"<?php echo $row['productName']; ?>"</h5>
                                <p class="card-text"><?php echo $row['productDesc']; ?></p>
                                <p class="card-text">₱<?php echo $row['price']; ?></p>
                            </div>
                            <div class="footer">
                                <input type="hidden" name="productsID" value="<?php echo $row['productsID']; ?>">
                                <button type="submit" class="btn btn-dark" value="add-to-cart" name="add-to-cart">Add to cart</button>                      
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
