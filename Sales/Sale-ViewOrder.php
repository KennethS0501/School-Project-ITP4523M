<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
</head>

<body>
  <div class="SaleAndManagerform">
    <table border="solid" >

      <tr>
        <td>Order id</td>
        <td>Email</td>
        <td>Handle staff</td>
        <td>order date and time</td>
        <td>delivery address</td>
        <td>delivery date(if(0000-00-00) mean null)</td>
        <td>amount</td>
      </tr>
      <?php
        session_start();
    
        include "../conn.php";
        $GetOrder="SELECT * FROM orders";
        $DoingGetOrder =mysqli_query($conn,$GetOrder) or die(mysqli_error($conn));
        while ($Order = mysqli_fetch_assoc( $DoingGetOrder)) {
          extract($Order);
          echo"<tr>";  
          foreach($Order as $k=>$v)
          {
            echo"<td>$v</td>";
          }
          echo"</tr>";
        }
    
      ?>

    </table>

    <form action="recepict.php" method="post">
      <div class="inputtable">
        <div class="saleinputsub">see detail(email):<input type="email" name="SOemail" required>
          <input type="submit" name="Vsubmit" value="Search"></div>

      </div>

    </form>




  </div>
</body>

</html>
