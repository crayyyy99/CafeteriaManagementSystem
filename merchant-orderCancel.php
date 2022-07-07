<?php

/*This page processes the cancel order action*/

session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
include ('inc/connect.php');

$order_id=$_REQUEST['id'];
$status = "Cancelled";
$reason = "Cancelled by Merchant";
$now = date("Y-m-d H:i:s");

$sql = "UPDATE orders SET `status`='" .$status . "' , cancel_reason ='" .$reason . "'
, updated_at ='" .$now . "' where id=$order_id";

$result = $conn ->query($sql);

if($conn->query($sql) === TRUE)
{ 
    echo "<script>alert('Order successfully cancelled.');</script>";    
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

