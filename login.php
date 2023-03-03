<!-- PHP command to link server.php file with registration form  -->
<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login</title>

  <!-- <style>
         .container{
             justify-content: center;
             text-align: center;
             align-items: center;
         }
         input{
             padding: 5px;
         }
         .error{
             background-color: pink;
             color: red;
             width: 300px;
             margin: 0 auto;
         }
     </style> -->
  <style media="screen">
    *,
    *:before,
    *:after {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    .container {
      justify-content: center;
      color: whitesmoke;
      text-align: center;
      align-items: center;
    }

    input {
      padding: 5px;
    }

    .error {
      background-color: pink;
      color: red;
      width: 300px;
      margin: 0 auto;
    }

    body {
      background-color: royalblue;
    }

    .background {
      width: 430px;
      height: 520px;
      position: absolute;
      transform: translate(-50%, -50%);
      left: 50%;
      top: 50%;
    }

    .background .shape {
      height: 200px;
      width: 200px;
      position: absolute;
      border-radius: 50%;
    }

    .shape:first-child {
      background: linear-gradient(#1845ad,
          #23a2f6);
      left: -80px;
      top: -80px;
    }

    .shape:last-child {
      background: linear-gradient(to right,
          #ff512f,
          #f09819);
      right: -30px;
      bottom: -80px;
    }

    form {
      height: 520px;
      width: 400px;
      background-color: rgba(255, 255, 255, 0.13);
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 50%;
      border-radius: 10px;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
      padding: 50px 35px;
    }

    form * {
      font-family: 'Poppins', sans-serif;
      color: #ffffff;
      letter-spacing: 0.5px;
      outline: none;
      border: none;
    }

    form h3 {
      font-size: 30px;
      font-weight: 100;
      line-height: 42px;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 30px;
      font-size: 16px;
      font-weight: 500;
    }

    input {
      display: block;
      height: 40px;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.07);
      border-radius: 10px;
      padding: 0 10px;
      margin-top: 8px;
      font-size: 14px;
      font-weight: 300;
    }

    ::placeholder {
      color: #e5e5e5;
    }

    button {
      margin-top: 10px;
      width: 100%;
      background-color: #ffffff;
      color: #080710;
      padding: 15px 0;
      font-size: 18px;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
    }

    /* [class="button1"] {
      display: block;
      height: 20px;
      margin-top: 10px;
      float: right;
    }

    [class="text1"] {
      margin-top: -20px;
      float: left;
      color: white;
    } */
  </style>
</head>

<body>
  <div class="container">
    <h1> Graduation Registration System</h1>

    <h4><a href="index.php" style="text-decoration:none ; color: whitesmoke">Home Page</a></h4>
    <!--------log in form------>

    <div class="logInForm" id="logIn">
      <form method="POST">

        <!-- To show errors is user put wrong data -->
        <!-- <div class="error"> <?php echo $error2 ?> </div> -->

        <!-- To check the user loged In status -->
        <p>
          <?php
          if (!isset($_SESSION["id"])) {
            echo "<p>Please first log in to proceed.</p>";
          }
          ?>
        </p>

        <input type="email" name="email" placeholder="Email"> <br><br>
        <input type="password" name="password" placeholder="password"><br><br>
        <label for="checkbox">Stay logged in</label>
        <input type="checkbox" name="stayLoggedIn" id="chechbox" value="1"> <br><br>
        <button type="submit" name="logIn" value="Log In"> Login</button>

        <!-- User registration form link -->
        <br></br>
        <p>Not a register user ? <a href="daftar.php"> Create Account</a></p>
      </form>
    </div>
  </div>

  </script>

</body>

</html>