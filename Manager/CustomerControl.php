<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manager</title>
    <link rel="stylesheet" href="../CSS/designKenneth.css" type="text/css">
</head>

<body>
<div class="mainDiv">
    <div class="customerTable">
        <form action="CustomerControl.php" method="get">
            <input type="submit" value="Delete" class="itemButton">

        <table id="tableA" class="staffTable">
            <tr>
                <th><input type='checkbox' class='select' name='select'  onclick="selectAll(this)"/></th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Phone Number</th>
            </tr>
            <tbody>
            <script>
                function selectAll(source){
                    checkboxes = document.getElementsByName('selectedCustomer[]');
                    for(var i=0, n=checkboxes.length;i<n;i++) {
                        checkboxes[i].checked = source.checked;
                    }
                }
            </script>
            <?php
            include "../conn.php";

            if(isset($_GET['selectedCustomer'])){
                $customerEmail = $_GET['selectedCustomer'];

                $selectCount = count($customerEmail);
                echo("<h1 style='color: green'>The customer has been deleted.</h1>");
                for($i=0; $i < $selectCount; $i++)
                {
                    $sql = "DELETE i
                            FROM customer c
                            INNER JOIN orders o ON c.customerEmail = o.customerEmail
                            INNER JOIN itemorders i ON o.orderID = i.orderID
                            WHERE c.customerEmail = '".$customerEmail[$i]."';";

                    mysqli_query($conn, $sql);

                    $sql = "DELETE o
                            FROM orders o
                            WHERE o.customerEmail = '".$customerEmail[$i]."';";

                    mysqli_query($conn, $sql);

                    $sql = "DELETE c
                            FROM customer c
                            WHERE c.customerEmail = '".$customerEmail[$i]."';";

                    mysqli_query($conn, $sql);
                }
            }

            $sql = "SELECT * from customer";
            $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));

            if(mysqli_num_rows($rs) > 0){
                while($row = mysqli_fetch_assoc($rs)){
                    echo "<tr>
                            <td><input type='checkbox' class='select' name='selectedCustomer[]' value=".$row['customerEmail']."></td>
                            <td id='TableBDdata' >".$row["customerName"]."</td>
                            <td id='TableBDdata' >".$row["customerEmail"]."</td>
                            <td id='TableBDdata' >".$row["phoneNumber"]."</td>
                          </tr>";
                }
            }

            mysqli_close($conn);

            ?>

            </tbody>
        </table>
        </form>
    </div>
</div>
</body>

</html>
