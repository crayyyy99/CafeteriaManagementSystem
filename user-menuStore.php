<?php 

/*This page read the merchant ID when the user click on the store button and display the data based on the merchant ID*/

session_start();
$merchant_id = $_SESSION["merchant_id"];
include ('inc/connect.php');

$cus_id = $_SESSION["cus_id"];
date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Menu</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style copy.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            //control active page color in navigation bar
            <?php echo("var active = 'menu-nav';"); ?>
            <?php echo("var active2 = 'menu-nav-res';"); ?>
        </script>

        <script type="text/javascript">
            $(document).ready(function(){

                //Enlarge menu image when hover on them

                function hoverItem(){
                    $(".menu-table img").mouseenter(function(){
                        $(this).css("width", "350px");
                    });

                    $(".menu-table img").mouseleave(function(){
                        $(this).css("width", "50px");
                    });
                }

                hoverItem();
  
                //Display hostel address option if the delivery option = 'Delivery to Hostel'

                $("#del-type").on('change', function() {
                    var value=$(this).find(":selected").val();
                    if(value=="Delivery to Hostel")
                    $("#hostel_address").show();
                    else
                    $("#hostel_address").hide();
                });
            });
        </script>
        <style></style>
    </head>

    <body>
        <?php include ('user-header.php');?>
        
        <?php

            $sql = "SELECT * FROM merchants where id = '$merchant_id' ";    
            $result = $conn ->query($sql);      
            if($result->num_rows > 0) {        
                while($row = $result -> fetch_assoc()){
        ?>

        <section class="menu-container">
            <section class="breadcrumb-container">
                <ul class="breadcrumb">
                    <li><a href="user-menu.php">Store</a></li>
                    <li><?php echo $row['business_name']; ?></li> 
                </ul>
            </section>
            
            <div class="store-bg3" style="
                background:url(data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['business_bg']); ?>)
                no-repeat;background-size: cover; background-position: 10% 55%;" >
                <p><?php echo $row['business_name']; ?></p>               
                
            <?php
                }
            }
            ?>
            </div>              

            <section id="item-container">
                Date: <?php echo date('d/m/Y');?> <br><br>
                
                 <!--Allow user to select session to make order-->

                <form method = "POST" action="">
                    Select Session:
                    <select style="font-size:16px;" name = "session" size="1" onChange="this.form.submit()">
                        <option value='' disabled selected></option>
                        <option 
                        <?php if((isset($_POST['session']))&&($_POST['session']=='Morning')) {
                            echo "selected='selected'";
                            $_SESSION['session'] = 'Morning';
                        }
                        else if((isset($_SESSION['session']))&&($_SESSION['session']=='Morning')) {
                            echo "selected='selected'"; 
                            $_SESSION['session'] = 'Morning';
                        }?>>Morning</option>

                        <option 
                        <?php if((isset($_POST['session']))&&($_POST['session']=='Afternoon')) {
                            echo "selected='selected'";
                            $_SESSION['session'] = 'Afternoon';
                        }
                        else if((isset($_SESSION['session']))&&($_SESSION['session']=='Afternoon')) {
                            echo "selected='selected'"; 
                            $_SESSION['session'] = 'Afternoon';
                        }?>>Afternoon</option>

                        <option 
                        <?php if((isset($_POST['session']))&&($_POST['session']=='Evening')) {
                            echo "selected='selected'";
                            $_SESSION['session'] = 'Evening';
                        }
                        else if((isset($_SESSION['session']))&&($_SESSION['session']=='Evening')) {
                            echo "selected='selected'"; 
                            $_SESSION['session'] = 'Evening';
                        }?>>Evening</option>

                    </select>
                </form>

                <h3>Menu</h3>
                <form id = "order-form" method = "POST" action="user-menuConfirm.php" onSubmit="return confirm('Are you sure?');">
                <table class="menu-table">
                    <?php 
                    if(isset($_POST["session"])){
                        $_SESSION["session"]=$_POST["session"];
                        include ("user-menuStoreView.php");
                    }
                    else if(isset($_SESSION["session"])){
                        include ("user-menuStoreView.php");
                    }

    ?>

            </section>


        </section>

        <?php include ('footer.php');?>  

    </body>
</html>