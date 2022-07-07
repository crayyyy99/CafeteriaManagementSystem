<?php

/*This page processes the delete menu item action*/

session_start();

include ('inc/connect.php');

$id=$_REQUEST['id'];

//Read item data from database
$sql="SELECT count(items.id) as count
from items join order_details on order_details.item_id = items.id
where items.id =".$id;

$result = $conn ->query($sql);

if($result->num_rows > 0) {
    while($row = $result -> fetch_assoc()){
        $exist = $row['count'];
    }

    //if the item data exists in order table- cancel delete action, else -delete item in database
    if($exist != 0 ){
        echo "<script>alert('You are not allowed to delete this item.');</script>";  
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-menu.php\">";    
    }
    else{
        $sql = "DELETE from items where id='".$id."'";

        $result = $conn ->query($sql);
        
        if($conn->query($sql) === TRUE)
        {
            $sql = "DELETE from item_details where item_id='".$id."'";
        
            $result = $conn ->query($sql);
        
            if($conn->query($sql) === TRUE) {
            echo "<script>alert('Item successfully deleted.');</script>";  
            echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-menu.php\">";     
            }
            else {
                echo "<p>"; 
                echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
                echo "<p>";
            }
        }
        else
        {
            echo "<p>"; 
            echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
            echo "<p>";
        }
    }

}



$conn->close(); 

?>

