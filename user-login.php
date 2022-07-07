<!--This page shows the login page-->

<!DOCTYPE html>
<html>
    <head>
        <title>SCOS -Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       
    </head>

    <body>

    <?php
        //Initialize session
        session_start();

        if(isset($_SESSION["username"])) 
        {
            //Destroy the whole session
            $_SESSION = array();
            session_destroy();
        }
        ?>

        <section class = "bg-img"></section>
        <section class= "login-container"> 
            <section style="text-align: center; margin:10px;">
                <a href="index.php"><img src = "image/logo.png" alt="logo" style="width:40%;"></a>
            </section>
        
        <!--Login form-->
            <form action="user-loginProcess.php" method="POST">
                    
                <section class="user-choice">
                    <ul>
                        <li>User</li>
                        <li><a href="merchant-login.php">Merchant</a></li>
                    </ul>
                </section>

                <section>
                    <label for="email"><b>Email address</b></label><br/>
                    <input type="email" id="email" name="email" placeholder="Enter Login Email Address" required>

                    <label for="password"><b>Password</b></label><br/>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </section>

                <section class="user-choice2">
                    <ul>
                        <li style="float:left"><a href="registration.html">Create an account</a></li>
                        <li style="float:right"><a href="reset-pwd.php">Forgot your password?</a></li>
                    </ul>
                </section>  

                <input type="submit" value="Sign in">
                      
            </form>   
  
        </section>          

    </body>

</html>
