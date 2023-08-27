<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
  <script>
  

      window.history.forward();





  </script>
</head>

<body>



  <form action="Sale-ChangeOrder.php" method="post" id="updateform">
  <?php
      session_start();
    
    
      include "../conn.php";



      $goback=false;
    
      $tick=true;
      
      if(isset($_POST['SOid'])  )
      {
        $GetOrder="SELECT * FROM orders  ORDER BY orderID";
        $DoingGetOrder =mysqli_query($conn,$GetOrder) or die(mysqli_error($conn));
        while ($Order = mysqli_fetch_assoc( $DoingGetOrder)) 
        {
          extract($Order);

          if($_POST['SOid']==$orderID)
          {
            $Getid=" SELECT * FROM orders WHERE orderID='{$_POST['SOid']}'";
            $DoingGetid =mysqli_query($conn,$Getid) or die(mysqli_error($conn));
            $id = mysqli_fetch_assoc($DoingGetid);
            extract($id);
            echo"<div class='SaleAndManagerform'><div  class='saleinput'><input type='Text' name='Soid' value='{$_POST['SOid']}' readonly></div><table border='solid'>";
            echo"<tr>";
            echo "<td>Order ID:</td>";
            echo "<td>Customer’s Email:</td>";


            echo "<td>Staff ID:</td>";
            echo "<td>Order Date and Time: </td>";
            echo "<td>Delivery address:</td>";
            echo "<td>delivery date(if 0000-00-00 it mean null ):</td>";
            echo" <td>Total Amount:</td>";
            echo"</tr>";


            echo"<tr>";

            echo "<td>".$customerEmail."</td>";
            echo "<td>".$staffID."</td>";
            echo "<td>{$dateTime}</td>";
            echo "<td>{$deliveryAddress} </td>";
            echo "<td> {$deliveryDate}</td>";
            echo" <td>{$orderAmount}</td>";
            echo"</tr>";
            echo"</table>";
            echo"<div  class='saleinput'>Update Address<br><input type='text' value='{$deliveryAddress}' name='UPadd'><br></div>";
            echo"<div class='saleinput'>Update Delivery Date<br><input type='Date' value='{$deliveryDate}' name='UPDate'</div>";
            echo"<div class='saleinput'><input type='submit' name='Usubmit' value='Update'></div> <br> ";
            $tick=false;
          }



      }
       
    }
    else
    {
      echo"no any order";
    }
    
    if(!empty($_POST['UPadd']) && !empty($_POST['UPDate'] ))
    {
     
      $UPid="UPDATE orders SET deliveryAddress='{$_POST['UPadd']}', deliveryDate='{$_POST['UPDate']}' WHERE orderID='{$_POST['Soid']}'";

      $DoingUPid = mysqli_query($conn,$UPid) or die(mysqli_error($conn));


      header("Location: http://127.0.0.1/ITP4523M_Project/Sales/Sale-UpdateOrder.php");

      exit();

    }
    else if($tick)
    {
      $GetOrder1="SELECT * FROM orders  ORDER BY orderID";
      $DoingGetOrder1 =mysqli_query($conn,$GetOrder1) or die(mysqli_error($conn));
      while ($Order1 = mysqli_fetch_assoc( $DoingGetOrder1)) 
      {
        extract($Order1);
        
        if($_POST['SOid']==$orderID)
        {
          echo"<script>alert('input please try again')</script>";
          $Getid=" SELECT * FROM orders WHERE orderID='{$_POST['Soid']}'";
          $DoingGetid =mysqli_query($conn,$Getid) or die(mysqli_error($conn));
          $id = mysqli_fetch_assoc($DoingGetid);
          extract($id);
          echo"<div class='SaleAndManagerform'><div  class='saleinput'><input type='Text' name='Soid' value='{$_POST['Soid']}' readonly></div><table border='solid'>";
          echo"<tr>";
          echo "<td>Order ID:</td>";
          echo "<td>Customer’s Email:</td>";


          echo "<td>Staff ID:</td>";
          echo "<td>Order Date and Time: </td>";
          echo "<td>Delivery address:</td>";
          echo "<td>delivery date(if 0000-00-00 it mean null ):</td>";
          echo" <td>Total Amount:</td>";
          echo"</tr>";


          echo"<tr>";

          echo "<td>".$customerEmail."</td>";
          echo "<td>".$staffID."</td>";
          echo "<td>{$dateTime}</td>";
          echo "<td>{$deliveryAddress} </td>";
          echo "<td> {$deliveryDate}</td>";
          echo" <td>{$orderAmount}</td>";
          echo"</tr>";
          echo"</table>";
          echo"<div  class='saleinput'>Update Address<br><input type='text' value='{$deliveryAddress}' name='UPadd'><br></div>";
          echo"<div class='saleinput'>Update Delivery Date<br><input type='Date' value='{$deliveryDate}' name='UPDate'</div>";
          echo"<div class='saleinput'><input type='submit' name='Usubmit' value='Update'></div> 
          <br> ";
        }
      }
    }
  ?>
     

    </form>
</body>

</html>
