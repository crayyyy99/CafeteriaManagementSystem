<?php
/*This page processes the Order Update form */

session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
include ('inc/connect.php');

$order_id=$_REQUEST['id'];
$status = "Completed";
$now = date("Y-m-d H:i:s");

$sql = "UPDATE orders SET `status`='" .$status . "', updated_at ='" .$now . "' where id=$order_id";

$result = $conn ->query($sql);

if($conn->query($sql) === TRUE) 
{ 
    echo '<script>alert("Order successfully updated.")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-order.php\">";     
}
else
{
    echo "<p>"; 
    echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
    echo "<p>";
}

$conn->close(); 

?>

