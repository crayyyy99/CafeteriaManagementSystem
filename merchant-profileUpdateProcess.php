<?php

/*This page processes the Edit Profile form*/

session_start();

include ('inc/connect.php');
$username= $_SESSION['username'];

$name = $_POST['u_name'];
$ic = $_POST['u_ic'];
$gender = $_POST['u_gender'];
$contact = $_POST['u_contact'];
$buss_name = $_POST['u_busname'];
$buss_unit = $_POST['u_busunit'];


$sql = "UPDATE merchants SET name='" .$name . "', ic='" .$ic . "', gender='" . $gender . "', contact='" . $contact . "'
, business_name='" . $buss_name . "', business_unit ='" . $buss_unit . "' where email='$username'";

$result = $conn ->query($sql);

if($conn->query($sql) === TRUE)
{
    echo '<script>alert("Your profile has been updated!")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-profileUpdate.php\">";    
}
else
{
    echo "<p>"; 
    echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
    echo "<p>";
}
  
$conn->close();

?>