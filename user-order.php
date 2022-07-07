<?php 

/*This page shows the order page with search date or month option*/

if(!isset($_SESSION)){
    session_start();
}

include ('inc/connect.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

if(isset($_SESSION['session'])) {
   unset($_SESSION['session']);
}

if(isset($_SESSION['order_id'])) {
    unset($_SESSION['order_id']);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Order Menu</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <script>
            //control active page color in navigation bar
            <?php echo("var active = 'order-nav';"); ?>
            <?php echo("var active2 = 'order-nav-res';"); ?>

            function resetTable(){
                <?php
                  unset($search);
                ?>
            }

        </script>
        <style>
            .btn1{
                width: auto;
                background-color: rgba(250, 128, 114, 0.8);
                color:black;
                font-size: 16px;
                cursor: pointer;
                letter-spacing: 1px;
                border: 1px solid #000000;
                border-bottom-width: 2.5px;
                border-radius: 6px;
                padding:4px 10px;
            }

            .btn1:hover{
                background-color: rgba(250, 128, 114, 1.0);
                color:white;
                transition: .6s ease;
            }

            .btn1:active{
                color: black;
            }
        </style>

    </head>

    <body>

        <?php include ('user-header.php');?>

        <section class="user-order-container">
            <section class="order-nav">
                <h2>Order</h2>
                <form method = "POST" action="">
                    Select Date: <input type="date" name="searchDate">            
                    <button type="submit" name="date-btn"><i class=" fa fa-search btn1" ></i></button>  
                    &nbsp;&nbsp;&nbsp; or &nbsp;&nbsp;&nbsp;
                    Month: <input type="month" name="searchMonth">
                    <button type="submit" name="month-btn"><i class=" fa fa-search btn1" ></i></button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button onclick="resetTable();" class="btn1">Reset Table</button><br><br><br>
                </form>
               
            </section>

            <section>
                <article class="history-container">
                    <div style="overflow-x:auto"> 
                    <table>

                        <?php include ('user-orderTable.php');?>
                       
                    </table> 
                    </div>                     
                           
                </article>

            </section>
          
           
        </section>
           
        <?php include ('footer.php');?>
        
    </body>
</html>