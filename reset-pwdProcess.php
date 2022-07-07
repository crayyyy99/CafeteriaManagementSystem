<?php

if(!isset($_SESSION)){
    session_start();
}

$email = $_POST['email'];

include ('inc/connect.php');

//Check whether the email exists in database

$sql = "SELECT * FROM logins WHERE email = '$email'";

$result = $conn ->query($sql);

if($result->num_rows > 0) {
    echo '<script>alert("Password reset request was sent successfully. Please check your email to reset your password.")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-login.php\">";      
}
else{
    echo '<script>alert("Invalid login email.")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-login.php\">";    
}

?>