<?php
include_once("./php/conn.php");

session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['customerID'])) {
            $customerId = $_SESSION['customerID'];
            $productsID = $_SESSION['productsID'];
            $quantities = $_POST['quantity'];
            $totalPrice = $_POST['totalPrice'];

            // Start a transaction to ensure consistency
            $conn->beginTransaction();

            try {
                // Insert order data into the order_tbl
                $insertOrder = $conn->prepare("INSERT INTO order_tbl (customerID, producsID, quantity, totalPrice, date_order) VALUES (:customer_id, :product_id, :quantity, :total_price, NOW())");

                // Loop through each product in the cart
                // foreach ($quantities as $cartId => $quantity) {
                //     // Fetch product details
                //     $selectProduct = $conn->prepare("SELECT productsID, price FROM cart_tbl WHERE cartID = :cartID");
                //     $selectProduct->bindParam(':cartID', $cartId);
                //     $selectProduct->execute();

                //     if ($selectProduct->rowCount() > 0) {
                //         $product = $selectProduct->fetch();
                //         $productId = $product['productsID'];
                //         $totalPricePerProduct = $product['price'] * $quantity;

                //         // Insert order data
                //         $insertOrder->bindParam(':customer_id', $customerId);
                //         $insertOrder->bindParam(':product_id', $productId);
                //         $insertOrder->bindParam(':quantity', $quantity);
                //         $insertOrder->bindParam(':total_price', $totalPricePerProduct);
                //         $insertOrder->execute();
                //     }
                // }

                // Remove products from the cart
                $deleteCart = $conn->prepare("DELETE FROM cart_tbl WHERE customerID = :customerID");
                $deleteCart->bindParam(':customerID', $customerId);
                $deleteCart->execute();

                // Commit the transaction
                $conn->commit();

                echo "Order completed successfully!";
            } catch (PDOException $e) {
                // An error occurred, rollback the transaction
                $conn->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "User not logged in.";
        }
    } else {
        echo "Invalid request method.";
    }
    ?>
