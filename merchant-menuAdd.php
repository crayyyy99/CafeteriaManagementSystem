<?php

/*This page processes the add item action (form)*/

session_start();
include ('inc/connect.php');

date_default_timezone_set("Asia/Kuala_Lumpur");

$merchant_id = $_SESSION['merchant_id'];
$session = $_SESSION['session'];
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

        $sql = "INSERT INTO items (item_name, image, category, description, session, price, status, created_at, updated_at, merchant_id)
        VALUES ('$name', '$imgContent', '$category', '$description', '$session', '$price', '$status', '$now', '$now', '$merchant_id')" 
        or die ("Error inserting data into table");     
        
    }else{ 
        echo '<script>alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.")</script>';
    } 
}
else{
    $sql = "INSERT INTO items (item_name, category, description, session, price, status, created_at, updated_at, merchant_id)
    VALUES ('$name', '$category', '$description', '$session', '$price', '$status', '$now', '$now', '$merchant_id')" 
    or die ("Error inserting data into table");
}


if($conn->query($sql) === TRUE) {
    $item_id = $conn->insert_id;

    $sql = "INSERT INTO item_details (stock_no, created_at, updated_at, item_id)
    VALUES ('$stock', '$now', '$now', '$item_id')" 
    or die ("Error inserting data into table");  

    if($conn->query($sql) === TRUE) {
        echo "<script>alert('Item successfully added.');</script>"; 
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