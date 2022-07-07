<?php 

/*This page display the monthly sales report  */

session_start();

//Control session variable of other pages.
#using session6
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


include ('inc/connect.php');
date_default_timezone_set("Asia/Kuala_Lumpur");
$now = date("Y-m");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -View Report</title>
        <link rel = "stylesheet" type="text/css" href = "style.css">
        <link rel = "stylesheet" type="text/css" href = "style copy.css">
        <link rel = "stylesheet" type="text/css" href = "style-responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            //control active page color in navigation bar
            <?php echo("var active = 'report-nav';"); ?>
            <?php echo("var active2 = 'report-nav-res';"); ?>

            $(document).ready(function(){
                $("#monthly-bseller").addClass("active-profile");
            });

            function resetTable(){
                <?php
                  $search=$now;
                ?>
            }

        </script>

    </head>

    <body>
        
        <?php include ('merchant-header.php');?>

        <section class="report-container">

            <section id="profile-nav" class="profile-nav-after" style="width:75%">
                <ul>
                    <li id="daily-sales"> <a href="merchant-reportDailySales.php">Daily Sales Report</a></li>
                    <li id="monthly-sales"> <a href="merchant-reportMonthlySales.php">Monthly Sales Report</a></li>
                    <li id="daily-bseller"> <a href="merchant-reportDailySeller.php">Daily Best-seller Report</a></li>
                    <li id="monthly-bseller"> <a href="merchant-reportMonthlySeller.php">Monthly Best-seller Report</a></li> 
                </ul>
            </section>

            <section class="profile-nav-element-container">
                <section class="history-container" style="padding: 10px 20px;">        
                    <h2>Monthly Sales Report</h2>

                    <!--Allow merchant to select session to view monthly sales report-->

                    <form id="session-form" method = "POST" action="">
                        Select Session:
                        <select style="font-size:16px;" name = "session" size="1" onChange="this.form.submit()">
                            <option value='' disabled selected></option>
                            <option 
                            <?php if((isset($_POST['session']))&&($_POST['session']=='Overall')) {
                                    echo "selected='selected'";
                                    $_SESSION['session6'] = 'Overall';
                                }
                                else if((isset($_SESSION['session6']))&&($_SESSION['session6']=='Overall')) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Overall';
                                }
                                else if( (isset($_POST['date-btn'])) && ($_SESSION['session6']=='Overall') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Overall';
                                }
                                else if( (isset($_POST['month-btn'])) && ($_SESSION['session6']=='Overall') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Overall';
                                }
                                ?>>Overall
                            </option>
                            <option 
                            <?php if((isset($_POST['session']))&&($_POST['session']=='Morning')) {
                                    echo "selected='selected'";
                                    $_SESSION['session6'] = 'Morning';
                                }
                                else if((isset($_SESSION['session6']))&&($_SESSION['session6']=='Morning')) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Morning';
                                }
                                else if( (isset($_POST['date-btn'])) && ($_SESSION['session6']=='Morning') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Morning';
                                }
                                else if( (isset($_POST['month-btn'])) && ($_SESSION['session6']=='Morning') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Morning';
                                }
                                ?>>Morning
                            </option>

                                <option 
                                <?php if((isset($_POST['session']))&&($_POST['session']=='Afternoon')) {
                                    echo "selected='selected'";
                                    $_SESSION['session6'] = 'Afternoon';
                                }
                                else if((isset($_SESSION['session6']))&&($_SESSION['session6']=='Afternoon')) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Afternoon';
                                }
                                else if( (isset($_POST['date-btn'])) && ($_SESSION['session6']=='Afternoon') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Afternoon';
                                }
                                else if( (isset($_POST['month-btn'])) && ($_SESSION['session6']=='Afternoon') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Afternoon';
                                }
                                ?>>Afternoon</option>

                                <option 
                                <?php if((isset($_POST['session']))&&($_POST['session']=='Evening')) {
                                    echo "selected='selected'";
                                    $_SESSION['session6'] = 'Evening';
                                }
                                else if((isset($_SESSION['session6']))&&($_SESSION['session6']=='Evening')) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Evening';
                                }
                                else if( (isset($_POST['date-btn'])) && ($_SESSION['session6']=='Evening') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Evening';
                                }
                                else if( (isset($_POST['month-btn'])) && ($_SESSION['session6']=='Evening') ) {
                                    echo "selected='selected'"; 
                                    $_SESSION['session6'] = 'Evening';
                                }
                                ?>>Evening</option>

                            </select>                      
                    </form><br>

        <?php 
                    if(isset($_SESSION['session6'])){
        ?>
                    <!--Enable search option-->

                    <form method = "POST" action="">
                        Select Month: <input type="month" name="searchDate" id="searchDate" >                      
                        <button type="submit" name="date-btn" id="date-btn"><i class=" fa fa-search btn1" ></i></button>  
                        &nbsp;&nbsp;&nbsp; 

                        <button onclick="resetTable();" class="btn1">Reset Table</button><br><br><br>
                    </form>  

        <?php 
                    if(isset($_POST["session"])){
                        $_SESSION["session6"]=$_POST["session"];
                        include ("merchant-reportMonthlySellerTable.php");
                    }
                    else{
                        include ("merchant-reportMonthlySellerTable.php");
                    }
  
            }
        ?> 
                </section>
            </section>
        </section>

        <?php include ('footer.php');?>

    </body>
</html>