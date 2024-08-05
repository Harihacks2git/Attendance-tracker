<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f4f8; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { 
            background-color: #ffffff;
             border-radius: 8px;
              box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
               padding: 40px; 
               width: 300px; 
               text-align: center; }
        h2 { margin-top: 0; color: #333; }
        label { display: block; 
            margin-bottom: 10px;
             text-align: left;
              color: #333; 
              font-weight: bold; }
        input[type="text"], input[type="password"] { 
            width: calc(100% - 22px);
             padding: 10px; 
             margin-bottom: 20px;
              border-radius: 6px; 
              border: 1px solid black;
             /* background-color: rgba(216, 214, 210, 0.1)  */
            color: black;    
            }
            input{
                background-color: transparent;
            }
        button { padding: 10px; border: none; border-radius: 25px; cursor: pointer; background-color:rgba(0, 0, 0, 0.562); color: white; font-size: 1em; transition: background-color 0.3s ease; }
        button:hover { background-color: grey; }
        .buttonsubmit { margin-top: 20px; justify-content: center; }
        .container{
          background-color:transparent;
        }
        .main{
            background-image: url("gradient.jpg");
            height: 100vh;
            width: 100vw;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            background-repeat: no-repeat;
            backdrop-filter: blur(100px);
        }
    </style>
</head>
<body class="main">
    <div class="container">
        <h2>PASSSWORD RESET</h2>
        <form id="loginForm" action="reset_password.php" method="POST">
            <div>
                <label for="email">Registered Email</label>
                <input type="text" id="email" name="email" class="in" required>
            </div>
            <div class="buttonsubmit">
                <button type="submit">RESET</button>
            </div>
        </form>
    </div>
</body>
</html>
