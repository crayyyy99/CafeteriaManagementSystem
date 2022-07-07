<?php

/*This page processes the account verification*/

//Initialize session
session_start();

if(!isset($_SESSION["username"])) 
{
    $email = $_POST['email'];
    $pwd = $_POST['password'];
          
    //Set up variables that will be saved as session variables
    $_SESSION['username']=$_POST['email'];
}

include ('inc/connect.php');

//Read logins data from database  
$sql = "SELECT * FROM logins WHERE email = '$email'";

$result = $conn ->query($sql);

if($result->num_rows > 0) {
    //output data of each row

    while($row = $result -> fetch_assoc()){
        $db_email=$row['email'];
        $db_pwd =  $row['password'];
        $permission = $row['permission'];
    }
   
//Verify the password by hashing the password input to match with hashed pwd in database
    if (password_verify($pwd, $db_pwd)) {
        if($permission == "Merchant"){
            echo '<script>alert("You do not have permission to access this panel.")</script>';
            session_unset();
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=user-login.php\">";    
        }
        else{
            //if valid logins, read the user data and redirect user to home page
            $sql = "SELECT * FROM customers WHERE email = '$email'";
            $result = $conn ->query($sql);
            if($result->num_rows > 0) {
                while($row = $result -> fetch_assoc()){
                    $_SESSION['cus_id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                }
            }

            echo "<meta http-equiv=\"refresh\" content=\"2;URL=user-home.php\">";
        }  
    }
    else{
        echo '<script>alert("Login Fail: Invalid login email or password.")</script>';
        session_unset();
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=user-login.php\">";    
    }
}
else{
    echo '<script>alert("Login Fail: Invalid login email or password.")</script>';
    session_unset();
    echo "<meta http-equiv=\"refresh\" content=\"2;URL=user-login.php\">";
}

//Closes specified connection
$conn->close();

?>
