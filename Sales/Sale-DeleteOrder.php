<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
</head>

<body>
  <div class="SaleAndManagerform">
     <form action="Sale-DeleteOrder.php" method="post">
    <table border="solid">
      <tr>
        <td>Order id</td>
        <td>Email</td>
        <td>Handle staff</td>
        <td>order date and time</td>
        <td>delivery address</td>
        <td>delivery date(if(0000-00-00) mean null)</td>
        <td>amount</td>
        <td>select</td>
      </tr>
      <?php
       

        $checkboxarray=array();
        include "../conn.php";
        $GetOrder="SELECT * FROM orders  ORDER BY orderID";
        $DoingGetOrder =mysqli_query($conn,$GetOrder) or die(mysqli_error($conn));
        while ($Order = mysqli_fetch_assoc( $DoingGetOrder)) {
          extract($Order);
          
          echo"<tr>";  
          foreach($Order as $k=>$v)
          {
            echo"<td>$v</td>";
          }
          echo"<td><input type='checkbox' name='{$orderID}' ></td>";

          echo"</tr>";
          $checkboxarray[$orderID]=$orderID;
          
          
        }
        $GetID="SELECT orderID FROM orders";
        $DoingGetID =mysqli_query($conn,$GetID) or die(mysqli_error($conn));
        $IDRecord=mysqli_fetch_assoc($DoingGetID);
        if(!isset($IDRecord) && !isset($_POST))
        {
          echo'<script>alert("no any order")</script>';
        }
        else if(isset($IDRecord))
        {
          $id=(max($IDRecord));
        }
        else
        {
          $id=0;
        }


     

        $lock=true;
        if(isset($_POST))
        {
          $message;
    
          foreach($_POST as $key=>$value)   
          {
              if($_POST[$key]=='on')
              {  
                if($lock)
                {
                  $message='<script>alert("the order deleted")</script>';
                  echo $message; 
                  $lock=false;
                }
               
                
                $DeleteItemOrder="DELETE FROM itemorders WHERE orderID='{$key}'";
                $DeleteOrder="DELETE FROM orders WHERE orderID='{$key}' ";
                $DoingDeleteItemOrder =mysqli_query($conn,$DeleteItemOrder) or die(mysqli_error($conn));
                $DoingDeleteOrder =mysqli_query($conn,$DeleteOrder) or die(mysqli_error($conn));
               
              }
       
              



            

          }
          foreach($_POST as $key=>$value)   
          {

            if($orderID!=$_POST[$key])
            {
              header("refresh:0.2");
              exit();

            }
          }
        }
    
      
    
          
          
          
        
        
        
    
      
    
      
      
      ?>




   
    </table>
  

    <div class="saleinputsub"><input type="submit" value="submit"  ></div>
      
    </form>
  </div>
</body>

</html>
