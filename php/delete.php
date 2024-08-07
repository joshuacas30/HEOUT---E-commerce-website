<?php
include_once("conn.php");

$id = $_GET['uid'];

$query = $conn->prepare("DELETE FROM products WHERE productsID = :uid");
$query->bindParam(":uid",$id);
$query->execute();

echo "<script>alert('Successfully Deleted!')</script>";
echo "<script>window.open('admin.php','_self')</script>";

?>