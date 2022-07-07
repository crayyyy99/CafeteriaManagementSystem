<?php 

/*This page display the change password page and the form*/

session_start();

include ('inc/connect.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Profile</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
        <script>
             //control active page color in navigation bar
            <?php echo("var active = 'profile-nav';"); ?>
            <?php echo("var active2 = 'profile-nav-res';"); ?>
                        
            $(document).ready(function(){
                $("#e-pwd").addClass("active-profile");
            });
        </script>

        <style>
            .profile-nav-element input[type=reset]{
                width: auto;
                background-color: rgba(250, 128, 114, 0.6);
                color:black;
                font-size: 16px;
                cursor: pointer;
                letter-spacing: 1px;
                border: 1px solid #000000;
                border-bottom-width: 2.5px;
                border-radius: 6px;
                line-height: 18px;
                padding:10px;
                margin-top: 10px;
            }
        </style>
        
    </head>

    <body> 
        <?php include ('user-header.php');?>

        <section class="merchant-profile-container" >

            <section id="profile-nav" class="profile-nav-after">
                <ul>
                    <li id="v-profile"> <a href="user-profileView.php">View Profile</a></li>
                    <li id="e-profile"> <a href="user-profileUpdate.php">Edit Profile</a></li>
                    <li id="e-pwd"> <a href="user-profilePwd.php">Edit Password</a></li>
                    <li> <a href="logout.php">Log Out</a></li>     
                </ul>
            </section>

            <section class="profile-nav-element-container">
                <section class="profile-nav-element">
                    <center>
                        <br><h3>CHANGE PASSWORD</h3>
                        <hr style='border-top:1px dashed black;width:80%;'>
                    </center>

                    <?php 
                    $username= $_SESSION['username'];

                    $sql = "SELECT * FROM logins WHERE email = '$username'";

                    $result = $conn ->query($sql);

                    if($result->num_rows > 0) {
                        //output data of each row

                        while($row = $result -> fetch_assoc()){
                            echo "<form method = 'post' action = 'user-profilePwdProcess.php'>";
                            echo "<input type='hidden' name='db_pwd' value ='" . $row['password']. "'>";
                            echo "<table>";
                            echo "<tr><th>Current Password:</th><td><input type ='password' name='current_pwd' 
                            required pattern='\S(.*\S)?' title='The field should not be null.'></td></tr>";
                            echo "<tr><th>New Password:</th><td><input type ='password' name='new_pwd'";
                            echo "pattern='.{8,}' required title='Your password needs to be at least 8 characters long.'></td></tr>";

                            echo "<tr><th>Confirm New Password:</th><td><input type ='password' name='new_pwd2'";
                            echo "pattern='.{8,}' required title='Your password needs to be at least 8 characters long.'></td></tr>";
                            echo "<tr><th colspan='2'> <input type='submit' name='submit' value='Change Password'>";
                            echo " <input type='reset' name = 'reset' value='Reset'></th>";
                        }

                    }
                    echo "</table>";
                    echo "<br>";
                    echo "</form>";

                    $conn->close();

                    ?>     

                </section>
            </section>
           
           
        </section>

        <?php include ('footer.php');?>

    </body>
</html>