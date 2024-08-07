<?php
// include_once("conn.php");
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // User is not logged in, redirect to login page
//     header('Location: login.php');
//     exit();
// }

include_once("conn.php");
if(isset($_SESSION['customerID'])){
	$uid = $_SESSION['customerID'];
	$userQuery = $conn->prepare("SELECT username FROM customer WHERE customerID = :uid");
	$userQuery->bindParam(':uid', $uid);
	$userQuery->execute();
	
	while($data = $userQuery->fetch()){
		$username = $data['username'];
		
	}
} else {
	header("Location:../index.php");
	die();
}
?>