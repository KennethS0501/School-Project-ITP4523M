<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="CSS/designKenneth.css" type="text/css">
  <?php
    session_start();
    include "conn.php";

    $staffID = null;
    $password = null;

    $message = null;

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //if submit form
        $staffID = $_POST["staffID"];
        $password = $_POST["password"];

        $sql = "SELECT * from staff WHERE staffID ='".$staffID."' AND password ='".$password."'";
        $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));

        if (mysqli_num_rows($rs) === 1){
            $row = mysqli_fetch_assoc($rs);

            if($row['staffID'] === $staffID && $row['password'] === $password){
                $_SESSION['staffID'] = $row['staffID'];
                $_SESSION['staffName'] = $row['staffName'];
                $_SESSION['position'] = $row['position'];

                if($row['position'] == "Manager"){
                    header("Location: http://127.0.0.1/ITP4523M_Project/Manager/ManagerMenu.php");
                    exit();
                } else if($row['position'] == "Staff"){
                    header("Location: http://127.0.0.1/ITP4523M_Project/Sales/SalesMenu.php");
                    exit();
                }
            }
        } else {
            $message .= "Invalid staff id or password, Please try again.";
        }
    }
  ?>
</head>
<body>
  <div class="container">
    <div class="logo"><a class="logoText">Better Limited</a></div>

    <div class="menuRight">
      <a href="index.php">Login</a>
    </div>
  </div>

  <div class="LoginMainDiv">
    <form action="index.php" method="post">
      <div class="loginFormDiv">
        <div class="loginForm">
          <div class="loginLabel">
            <input class="textInput" type="text" name="staffID" id="userid" value="<?php if(isset($_POST['staffID'])) { echo $_POST['staffID']; } ?>" placeholder="Staff ID" required>
          </div>
          <div class="loginLabel">
            <input class="textInput" type="password" name="password" placeholder="Password" required>
          </div>

          <br>
          <div class="loginLabel" style="border: none;">
            <input class="loginBtn" type="submit" value="Login" name="submit">
          </div>
          <?php
          if($_SERVER["REQUEST_METHOD"] == "POST") {
              echo '<div class="errorMessage" style="border: none;">' . $message . '<a class="inputInvalid">';
          }
          ?>
        </div>
      </div>
    </form>
  </div>
</body>

</html>
