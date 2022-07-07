<?php

/*This page is the index page of the system*/

//Initialize session
session_start();

if(isset($_SESSION["username"])) 
{
    //Destroy the whole session
    $_SESSION = array();
    session_destroy();
}
?> 


<!DOCTYPE html>
<html>
    <head>
        <title>SCOS</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>

        <header>
            <!--Show the top navigation bar-->
            <div id="nav-container">
                <img class="logo" src = "image\logo.png" alt="logo">
             
                <div class="links">
                    <ul>
                        <li class= "nav-style"> <a href="user-login.php"><img src = "image\account.png" alt="account"
                            style="width: 20px;" >Sign In</a></li>
                    </ul>
                </div>
            </div>
            
        </header>

        <section class="index-content">
            <div class="index-content-left">
                <h1 style="font-size: 54px;">SCOS</h1>
                <h3 style="font-size: 30px;color: #707070;font-weight: 100;margin: 20px 0 10px;">Satria Cafeteria<br>Ordering System</h3>
                <h4 style="margin: 30px 0;font-size: 16px;color: #b7b7b7;font-weight: 100;">Together We Stop the Spreading of Covid-19.</h4>
            </div>

            <?php include ('slideshow.php');?>
        </section>

        <?php include ('footer.php');?>

    </body>
</html>