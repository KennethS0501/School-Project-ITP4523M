<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sale</title>
  <link rel="stylesheet" href="../CSS/design.css" type="text/css">
  <script>
    function show() {

      var checkbox = document.getElementById('deliv');
      var deliveryAddressDiv = document.getElementById('deliveryAddressDiv');
      var deliveryDateDiv = document.getElementById('deliveryDateDiv');
      var address = document.getElementById('address');
      var date = document.getElementById('date');
      if (checkbox.checked) {
        deliveryAddressDiv.style['display'] = 'block';
        deliveryDateDiv.style['display'] = 'block';
        address.style['display'] = 'block';
        date.style['display'] = 'block';
      } else {
        deliveryAddressDiv.style['display'] = 'none';
        deliveryDateDiv.style['display'] = 'none';
        address.style['display'] = 'none';
        date.style['display'] = 'none';
      }
    }
    window.history.forward();

    var itemListCount = 0;

  </script>


</head>

<body>

  <?php 
    include "../conn.php";
   
  
    echo("<br>");
    date_default_timezone_set('Asia/Hong_Kong');
    $t=time();
    $date=date("Y-m-d",$t);
    $time=date("G:i:s",$t);
    $dateandtime= $date." ".$time;

  
  
  
    session_start(); 

  
  ?>
  <div class="SaleAndManagerform">
      <div><a>Total Price: </a><a id="totalPrice">0</a>(No calculate with discount yet)</div>
    <form action="Sale-CreateOrder.php" method="post" class="inputtable">
      <table border="solid">
        <tr>
          <td>Product id</td>
          <td>Name</td>
          <td>Description</td>
          <td>current qty</td>
          <td>Price</td>
          <td>Select</td>
          <td>qty</td>

        </tr>
        <?php
        $GetID="SELECT orderID  FROM orders ORDER BY orderID ASC;";
        $DoingGetID =mysqli_query($conn,$GetID) or die(mysqli_error($conn));
        $IDRecord=mysqli_fetch_assoc($DoingGetID);

        $message;
           
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
          $DoingGetdamnID1 =mysqli_query($conn,$GetdamnID) or die(mysqli_error($conn));
          while($IDRecord1=mysqli_fetch_assoc($DoingGetdamnID1))
          {
            
            extract($IDRecord1);
          
          
            $orderIDarray[$orderID]=$orderID*1;
      

            
          }
          $max=maxValueInArray($orderIDarray);

          $id=(($max)+1);
        }
       
     
     
      
    
        /*$itemprice=array();
        $checkboxarray=array();*/

        $itemID = array();
        $itemPrice = array();


        $sql = "SELECT * from item ORDER BY itemID ASC";
        $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));


        $i = 0;
        if(mysqli_num_rows($rs) > 0){
            while($row = mysqli_fetch_assoc($rs)){
                echo "<tr>
                        <td id='TableBDdata' name='itemID[]'>".$row["itemID"]."</td>
                        <td id='TableBDdata'  >".$row["itemName"]."</td>
                        <td id='TableBDdata'  >".$row["itemDescription"]."</td>
                        <td id='TableBDdata'  >".$row["stockQuantity"]."</td>
                        <td id='TableBDdata' name='price[]' >".$row["price"]."</td>
                    ";
                echo"<td><input type='checkbox' id='itemCheckBox'  name='itemCheckBox[".$i."]' class='a' onclick='changeCanEdit(); showTotalAndDiscount();'></td>";
                echo"<td><input type='number' id='itemQtyBox' name='itemQtyBox[".$i."]' onclick='showTotalAndDiscount()' class='b' pattern='[1-9]' min='1' max='{$row["stockQuantity"]}' disabled='disabled' required></td>";
                echo"</tr>";

                $i++;
                array_push($itemID, $row["itemID"]);
                array_push($itemPrice, $row["price"]);
            }

            $itemCheckBox = array();
            $itemQtyBox = array();
            for($i = 0; $i < count($itemID); $i++){
                if(isset($_POST['itemCheckBox'][$i])){
                    array_push($itemCheckBox,$_POST['itemCheckBox'][$i]);
                    array_push($itemQtyBox,$_POST['itemQtyBox'][$i]);
                } else {
                    array_push($itemCheckBox,NULL);
                    array_push($itemQtyBox,NULL);
                }
            }
        }

        //total price
        //discount API
        $discount = 0;
        $total = 0;
        for($i = 0; $i < count($itemID); $i++){
            if(isset($itemQtyBox[$i])){
                $total += $itemQtyBox[$i] * $itemPrice[$i];

                //discount API


            }
        }

        if($total != 0){
            $url = "http://127.0.0.1:8080/api/discountCalculator/$total";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $discount =  (1-curl_exec($curl));   # Perform a cURL session
            curl_close($curl);
            $total = $total * $discount;
        }

        if(isset($_POST['email'])){
            $sql = "SELECT * from customer where customerEmail='{$_POST['email']}'";
            $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if(mysqli_num_rows($rs)) {
                exit('This email address is already used!');
            }
            else{
              //customer
              //email > name > phoneNumber
              $sql = "INSERT INTO customer
                      VALUES ('".$_POST['email']."', '".$_POST['name']."', '".$_POST['tel']."')";
              mysqli_query($conn, $sql);
            }

            
            //orders
            //orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount(Kenneth)
            if(isset($_POST['address'])){
                $sql = "INSERT INTO orders
                    VALUES ('".$_POST['orderId']."', '".$_POST['email']."', '".$_SESSION['staffID']."', '".$dateandtime."', '".$_POST['address']."', '".$_POST['date']."','".$total."')";
            } else {
                $sql = "INSERT INTO orders
                    VALUES ('".$_POST['orderId']."', '".$_POST['email']."', '".$_SESSION['staffID']."', '".$dateandtime."', NULL, NULL,'".$total."')";
            }
            mysqli_query($conn, $sql);

            //orderItem
            //mutil insert
            //orderID(same), itemID(diff), itemQty(diff), soldPrice(item price * qty))
            for($i = 0; $i < count($itemID); $i++){
                if(isset($itemQtyBox[$i])){
                    $sql = "INSERT INTO itemorders
                    VALUES ('".$_POST['orderId']."', '".$itemID[$i]."', '".$itemQtyBox[$i]."', '".($itemPrice[$i] * $discount) * $itemQtyBox[$i]."')";
                    mysqli_query($conn, $sql);
                }
            }

            //item --stock
            //update
            //where itemID, itemQty
            for($i = 0; $i < count($itemID); $i++){
                if(isset($itemQtyBox[$i])){
                    $sql = "UPDATE item SET stockQuantity = stockQuantity -".$itemQtyBox[$i]." WHERE itemID='".$itemID[$i]."'";
                    mysqli_query($conn, $sql);
                }
            }
      
        }
      

      ?>

      </table>



      <! -- the start of form-->



        <div id="fulltalbe">
          <div class="inputtable">



            <?php


            echo("<div class='saleinput'> order ID<br><input type='number'  name='orderId' value='{$id}' readonly></div>");


            ?>


            <script>
                var price = document.getElementsByName('price[]');
                var itemCheckBox = document.getElementsByClassName("a");
                var itemQtyBox = document.getElementsByClassName("b");

                function changeCanEdit(){
                    for (var i = 0; i < itemCheckBox.length; i++){
                        if(itemCheckBox[i].checked){
                            if(itemQtyBox[i].value=="")
                            {
                              itemQtyBox[i].disabled = false;
                              itemQtyBox[i].value = "1";
                            }
                       
                        } else {
                            itemQtyBox[i].disabled = true;
                            itemQtyBox[i].value = "";
                        }
                    }
                }

                function checkEmpty(){
                    var alertMessage = "";
                    var itemCheckMode = false;
                    var alertMode = false;
                    if(document.getElementById('deliv').checked){
                        if(document.getElementById('address').value.trim() === ""){
                            alertMessage += "Please input delivery address!\n";
                            alertMode = true;
                        }
                        if (document.getElementById('date').value.trim() === ""){
                            alertMessage += "Please input delivery date!\n"
                            alertMode = true;
                        }
                    }

                    for (var i = 0; i < itemCheckBox.length; i++){
                        if(!itemCheckBox[i].checked){
                            itemCheckMode = true;
                            alertMode = true;
                        }
                    }

                    for (var i = 0; i < itemCheckBox.length; i++){
                        if(itemCheckBox[i].checked){
                            alertMode = false;
                        }
                    }

                    if(itemCheckMode){
                        alertMessage += "Please add some item to shipping cart!\n"
                    }

                    if(alertMode){
                        alert(alertMessage);
                        return false;
                    } else {
                        return true;
                    }
                }

                function showTotalAndDiscount(){
                    var total = 0;
                    for (var i = 0; i < itemQtyBox.length; i++){
                        if(itemCheckBox[i].checked){
                            total += parseInt(itemQtyBox[i].value) * parseInt(price[i].innerHTML);
                        }
                    }
                    document.getElementById("totalPrice").innerHTML = total;
                    console.log(total);
                }
            </script>

            <div class="saleinput">Customer Name: <br><input type="text" name="name"  id="name" pattern="[A-Za-z ]+" title="only endlist word" required></div>
            <div class="saleinputemail">Email:<br><input type="email"  id="email" name="email" required></div>
            <div class="saleinput">Phone:<br><input type="tel" name="tel" id="tel"  pattern="[0-9]{8}" title="accpet 8 number" required></div>
            <div class="saleinput"> delivery:<br> <input type="checkbox" id="deliv" onclick="show()"></div>

            <div class="saleinput" id="deliveryAddressDiv" style="display:none;">Delivery address:<br> <input type="text"  id="address" name="address" style="width:700px"></div>

            <div class="saleinput"  id="deliveryDateDiv" style="display:none;">Delivery date:<br> <input type="Date" id="date" name="date" style="width:200px"></div>

            <div class="saleinputsub"><input type="submit" name="sub" value="edit" onclick="return checkEmpty()"></div>
          </div>
        </div>
    </form>
    <! -- the end of form-->


  </div>




</body>

</html>
