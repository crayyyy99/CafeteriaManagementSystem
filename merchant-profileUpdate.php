<?php 

/*This page read the profile data from the database and display them in the Edit Profile Form */

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
                $("#e-profile").addClass("active-profile");
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
        <?php include ('merchant-header.php');?>

        <section class="merchant-profile-container" >

            <section id="profile-nav" class="profile-nav-after">
                <ul>
                    <li id="v-profile"> <a href="merchant-profileView.php">View Profile</a></li>
                    <li id="e-profile"> <a href="merchant-profileUpdate.php">Edit Profile</a></li>
                    <li id="e-pwd"> <a href="merchant-profilePwd.php">Edit Password</a></li>
                    <li> <a href="logout.php">Log Out</a></li>     
                </ul>
            </section>

            <section class="profile-nav-element-container">
                <section class="profile-nav-element">
                    <center>
                        <br><h3>UPDATE PROFILE</h3>
                        <hr style='border-top:1px dashed black;width:80%;'>
                    </center> 
                       
                    <?php 
                        $username= $_SESSION['username'];

                        //Read merchant data from database and Displayu=
                        
                        $sql = "SELECT * FROM merchants WHERE email = '$username'";

                        $result = $conn ->query($sql);

                        if($result->num_rows > 0) {
                            //output data of each row

                            while($row = $result -> fetch_assoc()){
                                echo "<form method = 'post' action = 'merchant-profileUpdateProcess.php'>";
                                echo "<table>";
                                echo "<tr><th>Name: </th><td><input type ='text' name='u_name' style='text-transform: uppercase' value ='" . $row['name']. "' 
                                required pattern='\S(.*\S)?' title='The field should not be null.'></td></tr>";
                                
                                echo "<tr><th>IC: </th><td><input type ='text' name='u_ic' value ='" . $row['ic']. "'
                                pattern='[0-9.]+' required title='The value must be a number.'></td></tr>";
                               
                                if($row['gender']=="Female"){
                                    echo "<tr><th>Gender: </th><td><input type ='radio' name='u_gender' value = Female checked>Female
                                    <input type ='radio' name='u_gender' value = Male>Male</th></tr>";
                                }
                                else{
                                    echo "<tr><th>Gender: </th><td><input type ='radio' name='u_gender' value = Female>Female
                                    <input type ='radio' name='u_gender' value = Male checked>Male</th></tr>";
                                }

                                echo "<tr><th>Login Email: </th><td>". $row['email']. "</td></tr>";
                                echo "<tr><th>Phone: </th><td><input type ='text' name='u_contact' value ='" . $row['contact']. "'pattern='[0-9.]+' required 
                                title='The value must be a number.' placeholder='60XXXXXXXXX'></td></tr>";
                                
                                echo "<tr><th>Business Name: </th><td><input type ='text' style='text-transform: uppercase' name='u_busname' value ='" . $row['business_name']. "'
                                required pattern='\S(.*\S)?' title='The field should not be null.'></td></tr>";
                                
                                echo "<tr><th>Business Unit: </th><td><input type ='text' name='u_busunit' style='text-transform: uppercase' value ='" . $row['business_unit']. "'
                                required pattern='\S(.*\S)?' title='The field should not be null.'></td></tr>";
                                
                                echo "<tr><th colspan='2'> <input type='submit' name='submit' value='Save'>";
                                echo " <input type='reset' name = 'reset' value='Reset'></th>";

                            }
                            echo "</table>";
                            echo "<br>";
                            echo "</form>";
                        }
                        else
                        {
                            echo "no record";
                        }

                        $conn->close();

                    ?>
                           
                </section>
            </section>
                  
        </section>

        <?php include ('footer.php');?>

    </body>
</html>