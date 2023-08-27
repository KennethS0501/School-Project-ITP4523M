<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
</head>

<body style="overflow-y:auto; height: auto; margin-bottom: 200px;">
<div style="overflow-y:auto; height: auto; margin-bottom: 200px;">
    <div style="margin-bottom: 1000px;">
    <?php
    session_start();


    include "../conn.php";
    $Getid="
        SELECT *
        FROM orders
        WHERE customerEmail='{$_POST['SOemail']}'

       ";

    $DoingGetid =mysqli_query($conn,$Getid) or die(mysqli_error($conn));
    while ( $id = mysqli_fetch_assoc($DoingGetid)) {
        extract($id);

        echo"<div class='SaleAndManagerform'><table border='solid'><tr><td>Product id</td><td>Name</td><td>qty</td></tr>";

        $GetOrder="SELECT item.itemID,itemName,orderQuantity FROM itemorders, item where itemorders.itemID=item.itemID  AND itemorders.orderID='{$orderID}' ORDER BY itemName DESC";

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
        echo"</table>";


        $GetCustomer="SELECT         
      customer.customerEmail
      ,customer.customerName
      ,customer.phoneNumber
      ,orders.staffID
      ,staff.staffName
      ,orders.dateTime
      ,orders.deliveryaddress
      ,orders.deliveryDate
      ,orders.orderAmount
      ,orders.orderID
      FROM customer
          ,orders 
          ,staff 
      WHERE customer.customerEmail=orders.customerEmail  
            AND staff.staffID= orders.staffID 
            AND orders.customerEmail ='{$_POST['SOemail']}'
      ;";
        $DoingGetCustomer =mysqli_query($conn,$GetCustomer) or die(mysqli_error($conn));
        $Customer = mysqli_fetch_assoc( $DoingGetCustomer);


        /*='{$_POST['SOemail']}'{$_POST['SOemail']}'*/




        echo "Order ID:{$orderID}";
        echo "<p>Customer’s Email:".$Customer['customerEmail']."</p>";
        echo "<p>Customer’s Name:".$Customer['customerName']."</p>";
        echo "<p>Customer’s Phone Number:".$Customer['phoneNumber']."</p>";
        echo "<p>Staff ID:".$staffID."</p>";
        echo "<p>Staff Name".$Customer['staffName']."</p>";
        echo "<p>Order Date and Time: {$dateTime}</p>";
        echo "<p>Delivery address:".$Customer['deliveryaddress']."</p>";
        echo "<p>delivery date(if 0000-00-00 it mean null ): {$deliveryDate}</p>";
        echo" <p>Total Amount:{$orderAmount}</p>";

        echo"</div>";

    }

    ?>
        </div>
</div>

