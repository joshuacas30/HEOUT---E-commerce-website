<?php
session_start();
include_once("./php/conn.php");

if (isset($_GET['cartId'])) {
    $cartId = $_GET['cartId'];

    // Remove the product from the cart_table
    $removeCart = $conn->prepare("DELETE FROM cart_tbl WHERE cartID = :cartID");
    $removeCart->bindParam(':cartID', $cartId);
    $removeCart->execute();

    header('location: cart.php');
    exit();
}
?>
