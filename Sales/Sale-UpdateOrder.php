<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
  <script>
   
  </script>
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
        include "../conn.php";
        session_start();
 
        $GetID="SELECT orderID  FROM orders ORDER BY orderID ASC;";
        $DoingGetID =mysqli_query($conn,$GetID) or die(mysqli_error($conn));
        $IDRecord=mysqli_fetch_assoc($DoingGetID);
        function maxValueInArray($array)
        {
          $currentMax = NULL;

          foreach($array as $key => $value)
          {
              if (($value >= $currentMax))
              {
                  $currentMax = $value;
              }
          }

            return $currentMax;
        }

        if(empty($IDRecord))
        {
          $id=1;
        }
        else
        {
          $GetdamnID="SELECT * FROM orders";
          $DoingGetdamnID =mysqli_query($conn,$GetdamnID) or die(mysqli_error($conn));
          $dmanIDRecord=mysqli_fetch_assoc($DoingGetdamnID);
          $orderIDarray=array();
          if($dmanIDRecord['orderID']==1)
          {
             $id=2;
          }
          while($IDRecord1=mysqli_fetch_assoc($DoingGetdamnID))
          {

            extract($IDRecord1);


            $orderIDarray[$orderID]=$orderID*1;



          }
          $max=maxValueInArray($orderIDarray);

          $id=(($max)+1);
        }
    
      
     
          $GetOrder="SELECT * FROM orders  ORDER BY orderID";
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

    <form action="Sale-ChangeOrder.php" method="post">
      <div class="inputtable">
       <?php
          $ID1=$id-1;
          echo"<div class='saleinputsub'>see detail(id):<input type='number' name='SOid' min='1' max='{$ID1}'required></div>"   
        ?>

          <div class='saleinputsub'><input type="submit" name="Vsubmit" value="Search"></div>

      </div>

    </form>




  </div>
</body>

</html>
