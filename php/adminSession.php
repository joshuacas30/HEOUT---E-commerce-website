<?php


include_once("conn.php");
if(isset($_SESSION['adminID'])){
	$id = $_SESSION['adminID'];
	$userQuery = $conn->prepare("SELECT username FROM admin_tbl WHERE adminID = :adminID");
	$userQuery->bindParam(':adminID', $id);
	$userQuery->execute();
	
	while($data = $userQuery->fetch()){
		$username = $data['username'];
	}
} else {
	header("Location:../index.php");
	die();
}
?>