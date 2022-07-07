<?php

/*This page processes the change password form*/

session_start();

include ('inc/connect.php');
$username= $_SESSION['username'];

$db_pwd = $_POST['db_pwd'];
$current_pwd = $_POST['current_pwd'];
$new_pwd = $_POST['new_pwd'];
$new_pwd2 = $_POST['new_pwd2'];

//Verify the password by hashing the password input to match with hashed pwd in database
//If current password input not same with current paswword -> return false
//If new password same as current password -> return false
//If new password1 and new password2 not match -> return false
//else update new password

if (password_verify($current_pwd, $db_pwd)) {
    if($new_pwd == $new_pwd2) {
        if (password_verify($new_pwd, $db_pwd)) {
            echo '<script>alert("The new password you entered is the same as your old password.")</script>';
            echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-profilePwd.php\">";    
        }
        else
        {
            $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
            $sql = "UPDATE logins SET password='" .$hashed_pwd . "' where email='$username'";
    
            $result = $conn ->query($sql);
    
            if($conn->query($sql) === TRUE)
            {
                echo '<script>alert("Your password has been updated!")</script>';
                echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-profilePwd.php\">";    
            }
            else
            {
                echo "<p>"; 
                echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
                echo "<p>";
            }
        }
       
    }
    else{
        echo '<script>alert("New passwords do not match.")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-profilePwd.php\">";    
    }
}
else{
    echo '<script>alert("The old password is incorrect.")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=merchant-profilePwd.php\">";    
}

  
$conn->close();

?>