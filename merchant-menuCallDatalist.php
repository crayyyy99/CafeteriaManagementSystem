<?php

include ('inc/connect.php');

/*This page reads data from database to become option of Datalist*/

$sql="SELECT DISTINCT category FROM items where merchant_id = '$merchant_id'";      
$result = $conn ->query($sql);

if($result->num_rows > 0) {

    //output data of each row
    while($row = $result -> fetch_assoc()){
        echo  "<option> ".$row['category']."<option/>"; 
    }
}

//Closes specified connection
$conn->close();

?>