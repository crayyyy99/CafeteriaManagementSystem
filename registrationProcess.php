<?php
include ('inc/connect.php');

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phoneno'];
$gender = $_POST['gender'];
$pwd = $_POST['password'];
$repwd = $_POST['repassword'];
$permission = "Customer";
$status = "Active";

//Read logins data from database and validate if login email existed, if no proceed with validate password

$sql = "SELECT * FROM customers WHERE email = '$email'";
$result = $conn ->query($sql);
if($result->num_rows > 0) {
    echo '<script>alert("This email has already been registered. Please use another email.")</script>';
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=registration.html\">";    
}
else{

    if($pwd == $repwd) {
        $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO logins (email, password, permission)
        VALUES ('$email','$hashed_pwd', '$permission')" 
        or die ("Error inserting data into table");
    
        if($conn->query($sql) === TRUE)
        {
            $sql = "INSERT INTO customers (name, gender, contact, status, email)
            VALUES ('$name','$gender', '$phone', '$status', '$email')" 
            or die ("Error inserting data into table");
    
            if($conn->query($sql) === TRUE)
            echo '<script>alert("Registered successfully. Please login.")</script>';
            echo "<meta http-equiv=\"refresh\" content=\"1;URL=user-login.php\">";    
        }
        else
        {
            echo "<p>"; 
            echo "<p style='text-align:center'>Error: " . $sql . "<br>" . $conn->error;
            echo "<p>";
        }
       
    }
    else{
        echo '<script>alert("Passwords do not match.")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=registration.html\">";    
    }

}






//Closes specified connection
$conn->close();

?>