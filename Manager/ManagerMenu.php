<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manager</title>
  <link rel="stylesheet" href="../CSS/designKenneth.css" type="text/css">
  <script type="text/javascript">
    function load_page(i) {
        switch (i){
            case 1:
                document.getElementById("main").innerHTML = '<object type="text/html" data="InsertItem.php" width="87%" height="190%"></object>';
                break;
            case 2:
                document.getElementById("main").innerHTML = '<object type="text/html" data="ManagerMonthlyReport.php" width="87%" height="190%"></object>';
                break;
            case 3:
                document.getElementById("main").innerHTML = '<object type="text/html" data="CustomerControl.php" width="87%" height="190%"></object>';
                break;
        }
    }

  </script>
  <?php
    session_start();
      if(!isset($_SESSION['position'])){
          exit("Target refused connection, Please login again.");
      }

      if(isset($_SESSION['position'])){
          if($_SESSION['position'] != "Manager"){
              exit("Target refused connection, Please login again.");
          }
      }
  ?>
</head>
<body>
  <div class="container">
    <div class="logo"><a class="logoText">Better Limited</a></div>
    <div class="menuRight">
            <a href="../php/logout.php">Logout</a>
    </div>
    <div class="menuRight" style="margin-right:0px; ">
      <a href="index.php" style="margin-right:0px; border-right:none; border-radius: 0px; ">User: <?php if(isset($_SESSION['staffName'])) {echo $_SESSION['staffName'];}?></a>
    </div>
  </div>

  <div class="leftMenu">
      <button class="dropbtn" onclick="load_page(1)">Item Control</button>
      <button class="dropbtn" onclick="load_page(2)">Monthly Report</button>
      <button class="dropbtn" onclick="load_page(3)">Customer Control</button>
  </div>

  <div class="mainDiv">
    <div class="main" id="main">
    </div>
  </div>

  <!--<div class="buttable">
    <div class="but" style="font-size:25px"><a href="ManagerUpdate.php">Update item</a></div>
    <div class="but" style="font-size:25px"><a href="ManagerMonthlyReport.php">Monthly report</a></div>
    <div class="but" style="font-size:25px"><a href="ManagerDeleteCustomerRecord.php">Delete Customer record</a></div>
  </div>
  <div class="SaleAndManagerform">
    <table border="solid">

      <tr>
        <td>Product id</td>
        <td>Name</td>
        <td>Description</td>
        <td>Qty</td>
        <td>Price</td>
      </tr>

      <tr>
        <td>111</td>
        <td>Air conditioner</td>
        <td>-</td>
        <td>20</td>
        <td>HK$4000</td>
      </tr>


      <tr></tr>
      <tr></tr>
    </table>
    <div id="fulltalbe">
      <form action="#" method="post" class="inputtable">
        <div class="inputtable">
          <div class="saleinput">ID: <input type="text" name="Inid" required></div>
          <div class="saleinputemail">Name: <br>
            <input type="text" name="InName" required></div>
          <div class="saleinput">Delivery address: <textarea style="width:400px;height:100px" required></textarea></div>
          <div class="saleinput">QTY: <br><input type="text" name="QTY" style="width:200px" required></div>
          <div class="saleinput">Price: <input type="text" id="amount" required></div>


          <div class="saleinputsub"><input type="submit" name="sub" value="submit" onclick="#"></div>
        </div>
      </form>
    </div>
  </div>-->
</body>
</html>
<?php

  ?>