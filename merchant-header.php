<?php

/*This page is the merchant panel header page*/

if(!isset($_SESSION)){
    session_start();
}

//Read user's name from database to be shown in top navigation bar (WELCOME message)
include ('inc/connect.php');
$sql = "SELECT * FROM merchants WHERE email = '".$_SESSION['username']."'";
$result = $conn ->query($sql);
if($result->num_rows > 0) {
    while($row = $result -> fetch_assoc()){
        $mer_name = $row['name'];
        $username = $row['email'];
        $merchant_id = $row['id'];
        $_SESSION['merchant_id'] = $row['id'];
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){

                //control active page background color in navigation bar
                $("#" + active).removeClass("nav-style");
                $("#" + active).addClass("active-nav");
                $("#" + active2).addClass("active-nav-res");

                //control responsive page design ->navigation bar becomes hamburger icon when screen <1060px
                if ($(window).width() < 1060) {
                    $("#hamburger").show();
                    $(".links").hide();    
                    $(".responsive-links").hide();    
                }
                else {
                    $(".links").show();
                    $("#hamburger").hide();
                    $(".responsive-links").hide();
                }

                $(window).on('resize', function() {
                    if ($(window).width() < 1060) {
                    $(".links").hide();
                    $("#hamburger").show();
                }
                else {
                    $(".links").show();
                    $("#hamburger").hide();
                    $(".responsive-links").hide();
                }
                });

                $("#hamburger").click(function(){
                    $(".responsive-links").toggle();
                });
              
            });
        </script>

    </head>

    <body>
        <header>
             <!--Show top navigation bar-->
            <div id="nav-container">
                <img class="logo" src = "image\logo.png" alt="logo">
                <div style="float:left; margin-left:20px;margin-top:25px; ">
                    <span style="font-size:20px;">Welcome</span>
                    <span style="font-size:22px;font-weight:bold; text-transform: uppercase;"><?php echo $mer_name; ?></span>     
                    &nbsp; &nbsp;&nbsp;&nbsp;
                </div>
               
                <div class="links">
                    <ul> 
                        <li class= "nav-style" id="home-nav"><a href="merchant-home.php">Home</a></li>
                        <li class= "nav-style" id="menu-nav"><a href="merchant-menu.php">Menu</a></li>
                        <li class= "nav-style" id="order-nav"> <a href="merchant-order.php">Order</a></li>
                        <li class= "nav-style" id="report-nav"> <a href="merchant-reportDailySales.php">Report</a></li>
                        <li class= "nav-style" id="profile-nav">  <a href="merchant-profileView.php">Profile</a></li>      
                    </ul> 
                </div>
                <a href="javascript:void(0);" id="hamburger" class="hamburger" onToggle="myFunction()">
                    <i class="fa fa-bars"></i>
                </a> 
            </div>
        </header>

        <!--Show navigation bar for responsive page-->
        <div class="responsive-links">
            <ul>
                <li id="home-nav-res"><a href="merchant-home.php">Home</a></li>
                <li id="menu-nav-res"><a href="merchant-menu.php">Menu</a></li>
                <li id="order-nav-res"><a href="merchant-order.php">Order</a></li>
                <li id="report-nav-res"><a href="merchant-reportDailySales.php">Report</a></li>
                <li id="profile-nav-res"> <a href="merchant-profileView.php">Profile</a></li>         
            </ul> 
        </div>

    </body>
</html>
