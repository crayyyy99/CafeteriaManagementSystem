<?php

session_start();
include ('inc/connect.php');

$username = $_POST['email'];

/*This page displays the business background image from Database*/

if(!empty($_FILES["image"]["name"])) { 
    // Get file info 
    
    $fileName = basename($_FILES["image"]["name"]); 
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
     
    // Allow certain file formats 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    if(in_array($fileType, $allowTypes)){ 
        $image = $_FILES['image']['tmp_name']; 
        $imgContent = addslashes(file_get_contents($image)); 

        $sql = "UPDATE merchants SET business_bg = '" .$imgContent . "' where merchants.email ='".$username."'"; 
      
        if($conn->query($sql) === TRUE) {
            echo "<script>alert('Background changed.');</script>";
            echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-home.php\">";     
        }
        else {
            echo "<p>"; 
            echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
            echo "<p>";
        }

        
    }else{ 
        echo '<script>alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-home.php\">";     
    } 
}
else{
    echo "<script>alert('No image file selected!');</script>";
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-home.php\">";     
}

$conn->close();

?>