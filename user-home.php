<?php 

/*This page shows the user(customer) panel home page*/

session_start();

if(isset($_SESSION['session'])) {
   unset($_SESSION['session']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Home</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
             //control active page color in navigation bar
            <?php echo("var active = 'home-nav';"); ?>
            <?php echo("var active2 = 'home-nav-res';"); ?>
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                //Animate the button to become eye-catching
                function loop() {
                    $("#makeOrder-btn")
                        .animate({opacity:'0.5'},1000)
                        .animate({opacity:'1.0'},1000, loop);
                } 

                document.getElementById("makeOrder-btn").addEventListener("load", loop());     
              
            });
        </script>

    </head>

    <body>
        <?php include ('user-header.php');?>

        <section class="index-content">
            <div class="index-content-left">
                <h1 style="font-size: 54px;">SCOS</h1>
                <h3 style="font-size: 30px;color: #707070;font-weight: 100;margin: 20px 0 10px;">Satria Cafeteria<br>Ordering System</h3>
                <h4 style="margin: 30px 0;font-size: 16px;color: #b7b7b7;font-weight: 100;">Together We Stop the Spreading of Covid-19.</h4>
                <button id="makeOrder-btn" onclick="location.href='user-menu.php';">Make an Order</button>
                
            </div>

            <?php include ('slideshow.php');?>

        </section>
        
        <?php include ('footer.php');?>

    </body>
</html>