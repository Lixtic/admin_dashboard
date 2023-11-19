<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeafah Healthcare - Login</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
       
    
    <div class="wrapper">
        <div class="form-box login"> 
                <div class="logo">  
                     <a href="index.html">
                         <img src="yeafah-logo.png" width="120" height="35" alt="Company Logo">
                        </a>   
                </div>
            <h2> Login</h2>
            <form id="loginForm" method="POST" action="process_login.php">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" id="email"  placeholder="Email" name="email" required>
                    
                </div>
                <div class="input-box">
                    
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" id="password" placeholder="password" name="password" required>
                </div>

                <div class="remember-forget">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forget password?</a>
                </div>
                
                <button class="btn" type="submit">Login</button>

                <div class="login-register">
                <p class ="Register-link">Don't have an account? <a href="register.php">Register</a></p>
                </div>
             </form>
       
         </div>
         <!-- Registeration form -->
       
      

        

    </div>

    <style> 
        *{
            margin: 0%;
            padding: 0%;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
         .wrapper{
            position: relative;
              width: 400px;
              height: 440px;
              background: transparent;
              border: 2px solid rgba(255, 255, 255, .5);
              border-radius: 20px;
              backdrop-filter: blur(20px);
              box-shadow: 0 0 30px rgba(0, 0, 0, .5);
              display: flex;
              justify-content: center;
              align-items: center;
    
            }

            .wrapper .form-box {
                width: 100%;
                padding: 40px;
            }
           

           
            .form-box h2{
                font-size: 1.5em;
                color: #162938;
                text-align: center;
            }
            .input-box{
                position: relative;
                width: 100%;
                height: 50px;
                border-bottom:2px solid #162938;
            }
            .input-box input{
                width: 100%;
                height: 100%;
                background: transparent;
                border: none;
                outline: none;
                font-size: 1em;
                font-weight: 600;
                padding: 0 35px 0 5px;
            }
            .input-box .icon{
                position: absolute;
                right: 8px;
                font-size: 1.2em;
                color: #162938;
                line-height: 57px;

            }
            /* .input-box input:focus~label,
            .input-box input:valid~label,{
                top: -5px;
            } */

            .remember-forget{
                font-size: 0.9em;
                color: #162938;
                font-weight: 500;
                margin: 20px 0 15px;
                display: flex;
                justify-content: space-between;
            }
            .remember-forget label input{
                accent-color: #162938;
                margin-right: 5px;
            }

            .remember-forget a{
                color: #162938;
            }
            .btn{
                width: 100%;
                background: #162938;
                border: none;
                outline: none;
                cursor: pointer;
                font-size: 1em;
                color: white;
                font-weight: 500;

            }
            .login-register{
                font-size: 0.9em;
                text-align: center;
                color: #162938;
                font-weight: 500;
                margin: 25px 0 15px;
            }
            .logo{
              
                
                position: relative;
                margin-right: 25px;
                margin-left: 100px;
                margin-bottom: 15px;
                align-content: center;
            }
            .login-register p a{
                color: #162938;
            }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #CDD2FF;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1600 900'%3E%3Cpolygon fill='%23c58c8c' points='957 450 539 900 1396 900'/%3E%3Cpolygon fill='%23eeeded' points='957 450 872.9 900 1396 900'/%3E%3Cpolygon fill='%23b4888a' points='-60 900 398 662 816 900'/%3E%3Cpolygon fill='%23c27377' points='337 900 398 662 816 900'/%3E%3Cpolygon fill='%23b74e60' points='1203 546 1552 900 876 900'/%3E%3Cpolygon fill='%23b6878e' points='1203 546 1552 900 1162 900'/%3E%3Cpolygon fill='%23933357' points='641 695 886 900 367 900'/%3E%3Cpolygon fill='%23e4dbdd' points='587 900 641 695 886 900'/%3E%3Cpolygon fill='%23c32f8f' points='1710 900 1401 632 1096 900'/%3E%3Cpolygon fill='%23952c6f' points='1710 900 1401 632 1365 900'/%3E%3Cpolygon fill='%23a295a2' points='1210 900 971 687 725 900'/%3E%3Cpolygon fill='%23cecdce' points='943 900 1210 900 971 687'/%3E%3C/svg%3E");
            background-attachment: fixed;
            background-size: cover;
            position: relative;
        }
        
    </style>

    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
