<?php

include_once("conn.php");

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    session_start();

    $statement = $conn->prepare("SELECT adminID FROM admin_tbl WHERE username = :username AND pass= :pword");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':pword', $password);
    $statement->execute();

    $count = $statement->rowCount();

    if ($count > 0) {
        while ($row = $statement->fetch()) {
            $id = $row['adminID'];

            // Set the username in the session
            $_SESSION['username'] = $username;
            $_SESSION['adminID'] = $id;
            
            echo "<script>alert('Login successful'); window.open('admin.php', '_blank'); window.location.href = 'admin.php';</script>";

            exit(); // Make sure to exit after the redirect
        }
    } else {
        echo "<script>alert('Sorry, Wrong Username or Password'); window.location.href = '../index.php';</script>";
        exit(); // Make sure to exit after the redirect
    }
}

?>