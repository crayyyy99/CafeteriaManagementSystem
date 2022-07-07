<?php

/*This page processes the edit menu form*/

session_start();
include ('inc/connect.php');

date_default_timezone_set("Asia/Kuala_Lumpur");

$item_id = $_POST['item_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$now = date("Y-m-d H:i:s");
if($stock==0) $status="Inactive";
else $status="Active";


if(!empty($_FILES["image"]["name"])) { 
    // Get file info 
    $fileName = basename($_FILES["image"]["name"]); 
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
     
    // Allow certain file formats 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    if(in_array($fileType, $allowTypes)){ 
        $image = $_FILES['image']['tmp_name']; 
        $imgContent = addslashes(file_get_contents($image)); 

        $sql = "UPDATE items SET item_name = '" .$name . "',image = '" .$imgContent . "' , category = '" .$category . "', description = '" .$description . "'
        , price = '" .$price . "', status = '" .$status . "', updated_at = '" .$now . "' where id = '$item_id'";     
        
    }else{ 
        echo '<script>alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.")</script>';
    } 
}
else{
    $sql = "UPDATE items SET item_name = '" .$name . "', category = '" .$category . "', description = '" .$description . "'
    , price = '" .$price . "', status = '" .$status . "', updated_at = '" .$now . "' where id = '$item_id'";
}

$result = $conn ->query($sql);

if($conn->query($sql) === TRUE) {

    $sql = "UPDATE item_details SET stock_no = '" .$stock . "', updated_at = '" .$now . "' where item_id = '$item_id'";

    $result = $conn ->query($sql);

    if($conn->query($sql) === TRUE) {
        echo "<script>alert('Item successfully updated.');</script>";   
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-menu.php\">";     
    }
    else {
        echo "<p>"; 
        echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
        echo "<p>";
    }
   
}
else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Closes specified connection
$conn->close();

?>