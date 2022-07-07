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
        <section class = "bg-img"></section>
        <section class= "login-container"> 
            <section style="text-align: center; margin:10px;">
                <a href="index.php"><img src = "image/logo.png" alt="logo" style="width:40%;"></a>
            </section>
            
            <!--Login form-->
            <form action="merchant-loginProcess.php" method="POST">
                    
                <section class="user-choice">
                    <ul>
                        <li><a href="user-login.php">User</a></li>
                        <li>Merchant</li>
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
                        <li style="float:left"><a href="reset-pwd.php">Forgot password?</a></li>
                    </ul>
                </section>  

                <input type="submit" value="Sign in">
                      
            </form>   
  
        </section>          

    </body>

</html>
