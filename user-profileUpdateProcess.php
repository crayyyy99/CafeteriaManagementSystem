<?php

/*This page processes the Edit Profile form*/

session_start();


include ('inc/connect.php');
$username= $_SESSION['username'];

$name = $_POST['u_name'];
$gender = $_POST['u_gender'];
$contact = $_POST['u_contact'];

$sql = "UPDATE customers SET name='" .$name . "', gender='" . $gender . "', contact='" . $contact . "'
where email='$username'";

$result = $conn ->query($sql);

if($conn->query($sql) === TRUE)
{
    echo '<script>alert("Your profile has been updated!")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-profileUpdate.php\">";    
}
else
{
    echo "<p>"; 
    echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
    echo "<p>";
}
  
$conn->close();

?>