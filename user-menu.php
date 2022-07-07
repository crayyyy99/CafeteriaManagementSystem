<?php 

/*This page display the store option for the user to choose. After the user selected the store, they will be redirected to the store page with menu*/

session_start();
include ('inc/connect.php');
if(isset($_SESSION['session'])) {
    unset($_SESSION['session']);
}
if(isset($_SESSION['merchant_id'])) {
    unset($_SESSION['merchant_id']);
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Order Menu</title>
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

            //Animate the store anchor when mouse hover them
            function mouseOverStore1(){
                $("#store-1").removeClass("store-bg");
                $("#store-1").addClass("store-bg2");
            }

            function mouseOutStore1(){
                $("#store-1").addClass("store-bg");
                $("#store-1").removeClass("store-bg2");
            }

            function mouseOverStore2(){
                $("#store-2").removeClass("store-bg");
                $("#store-2").addClass("store-bg2");
            }

            function mouseOutStore2(){
                $("#store-2").addClass("store-bg");
                $("#store-2").removeClass("store-bg2");
            }

        </script>

    </head>

    <body>

        <?php include ('user-header.php');?>
       
        <section class="menu-container">
            <section class="breadcrumb-container">
                <ul class="breadcrumb">
                    <li>Store</li>   

                </ul>
            </section>
            
            <section id="store-container">
            
            <!--Read merchant data from database and set the value and background image as detail in anchor button-->
                <ul>
                    <li>
                    <form name="form1" method = "POST" action="">
                        <input type="hidden" name="store_1" value="1">
                        <a><?php
                        
                        $sql = "SELECT * FROM merchants where id = 1 ";    
                        $result = $conn ->query($sql);      
                        if($result->num_rows > 0) {        
                            while($row = $result -> fetch_assoc()){
                                ?>
                        <div id="store-1" class="store-bg" style="
                        background:url(data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['business_bg']); ?>)
                        no-repeat;background-size: cover; background-position: 10% 55%;" 
                        onmouseover="mouseOverStore1();" onmouseout="mouseOutStore1();" name="store-2"  onClick="document.forms['form1'].submit();">
                            <p><?php echo $row['business_name']; ?></p>
                            
                          
                        <?php
                            }
                        }
                        ?>
                        </div>          
                        </a>
                    </form>
                    </li>
                    <li>
                    <form name="form2" method = "POST" action="">
                        <input type="hidden" name="store_2" value="2">
                        <a><?php
                        
                        $sql = "SELECT * FROM merchants where id = 2 ";    
                        $result = $conn ->query($sql);      
                        if($result->num_rows > 0) {        
                            while($row = $result -> fetch_assoc()){
                                ?>
                        <div id="store-2" class="store-bg" style="
                        background:url(data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['business_bg']); ?>)
                        no-repeat;background-size: cover; background-position: 10% 55%;" 
                        onmouseover="mouseOverStore2();" onmouseout="mouseOutStore2();" name="store-2" value = "2" onClick="document.forms['form2'].submit();">
                            <p><?php echo $row['business_name']; ?></p>
                          
                            </form>   
                        <?php
                            }
                        }
                        ?>
                        </div>          
                        </a>
                        </form>
                    </li>
                </ul>
                <?php

                //When the button is clicked, redirect user (with the merchant data) to the menu page.

                    if(isset($_POST["store_1"])){
                        $_SESSION["merchant_id"]=$_POST["store_1"];
                        echo "<meta http-equiv=\"refresh\" content=\"0.5;URL=user-menuStore.php\">";    
                    }
                    else if(isset($_POST["store_2"])){
                        $_SESSION["merchant_id"]=$_POST["store_2"];
                        echo "<meta http-equiv=\"refresh\" content=\"0.5;URL=user-menuStore.php\">";    
                    }

                ?>
            </section>
          
        </section>
           
        <?php include ('footer.php');?>

    </body>
</html>