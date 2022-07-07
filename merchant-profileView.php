<?php 

/*This page read the profile data from the database and display them */

session_start();

//Control session variable of other pages.
if(isset($_SESSION['session'])) {
    unset($_SESSION['session']);
 }
 if(isset($_SESSION['session2'])) {
     unset($_SESSION['session2']);
 }
 if(isset($_SESSION['session3'])) {
     unset($_SESSION['session3']);
 }
 if(isset($_SESSION['session4'])) {
    unset($_SESSION['session4']);
}
 if(isset($_SESSION['session5'])) {
     unset($_SESSION['session5']);
 }
 if(isset($_SESSION['session6'])) {
     unset($_SESSION['session6']);
 }

if(isset($_SESSION['edit-button'])) {
    unset($_SESSION['edit-button']);
}


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
                $("#v-profile").addClass("active-profile");
            });
        </script>

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
                        <br><h3>YOUR PROFILE</h3>
                        <hr style='border-top:1px dashed black;width:80%;'>
                    </center>

                    <?php 
                        $username= $_SESSION['username'];

                        //Display merchant data
                        $sql = "SELECT * FROM merchants WHERE email = '$username'";

                        $result = $conn ->query($sql);

                        if($result->num_rows > 0) {
                            //output data of each row

                            while($row = $result -> fetch_assoc()){
                                $_SESSION['merchant_id'] = $row['id'];
                                echo "<table>";
                                echo "<tr><th>Name: </th><td>" . $row['name']. "</td></tr>";
                                echo "<tr><th>IC: </th><td>" . $row['ic']. "</td></tr>";
                                echo "<tr><th>Gender: </th><td>" . $row['gender']. "</td></tr>";
                                echo "<tr><th>Login Email: </th><td>" . $row['email']. "</td></tr>";
                                echo "<tr><th>Phone: </th><td>" . $row['contact']. "</td></tr>";
                                echo "<tr><th>Business Name: </th><td>" . $row['business_name']. "</td></tr>";
                                echo "<tr><th>Business Unit: </th><td>" . $row['business_unit']. "</td></tr>";
                                echo "</tr>";
                            }
                            echo "</table>";
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