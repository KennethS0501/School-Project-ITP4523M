<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manager</title>
  <link rel="stylesheet" href="../CSS/designKenneth.css" type="text/css">

    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
    <script>
        <?php
            include "../conn.php";
            $GetID = "SELECT max(itemID) FROM item";
            $DoingGetID = mysqli_query($conn, $GetID) or die (mysqli_error($conn));
            $IDRecord = mysqli_fetch_assoc($DoingGetID);
            extract($IDRecord);
            $id = (max($IDRecord))+1;


            ?>;

        var id = <?php echo $id; ?>;

        function AddDataToTable(){

            var name = document.getElementById("name").value;
            var description = document.getElementById("description").value;
            var stockQuantity = document.getElementById("stockQuantity").value;
            var price = document.getElementById("price").value;

            markup = "<tr><td><input type='checkbox' class='select' name='select'/></td><td>" + id + "</td><td contenteditable='true'>" + name + "</td><td contenteditable='true'>" + description + "</td><td contenteditable='true'>" + stockQuantity + "</td><td contenteditable='true'>" + price + "</td></tr>";

            id++;
            $("#tableA").append(markup);
        }

        function insertItemIsEmpty()
        {
            var itemName = document.forms["insertForm"]["name"].value;
            var itemDescr = document.forms["insertForm"]["description"].value;
            var stockQuantity = document.forms["insertForm"]["stockQuantity"].value;
            var price = document.forms["insertForm"]["price"].value;

            if(itemName === ""){
                alert("Please input item name!")
                return false;
            } else if (itemDescr === ""){
                alert("Please input item description!")
                return false;
            } else if (stockQuantity === ""){
                alert("Please input stock quantity!")
                return false;
            } else if (price === ""){
                alert("Please input item price!")
                return false;
            } else {
                return true;
            }
        }

        function deleteRow() {
            document.querySelectorAll('#tableA .select:checked').forEach(e => {
                e.parentNode.parentNode.remove()
            });
        }

        function selectAll(source){
            checkboxes = document.getElementsByName('select');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        var a;
        function getDataTophp(){
            let dataArray = [];
            var arr = []
            let i = 1;


            $("document").ready(function() {
                var tb = $('#tableA:eq(0) tbody');
                var size = tb.find("tr").length;
                tb.find("tr").each(function(index, element) {
                    var colSize = $(element).find('td').length;
                    let rowIndex = index + 1;

                    const obj = {};
                    $(element).find('td').each(function(index, element) {

                        var colVal = $(element).text();
                        dataArray.push(colVal.trim());
                        colIndex = index;

                        if(rowIndex === i){
                            switch (colIndex){
                                case 1:
                                    obj['id'] = colVal.trim();
                                    break;
                                case 2:
                                    obj['name'] = colVal.trim();
                                    break;
                                case 3:
                                    obj['description'] = colVal.trim();
                                    break;
                                case 4:
                                    obj['stock'] = colVal.trim();
                                    break;
                                case 5:
                                    obj['price'] = colVal.trim();
                                    break;
                            }
                        }
                    });i++;
                    if(rowIndex !== 1){
                        arr.push(obj);
                    }
                });

                a = JSON.stringify(arr);

                console.log(a);

                document.getElementById("data").innerHTML = a;
            });
        }

        function modifyTophp(){
            let dataArray = [];
            var arr = []
            let i = 1;
            var a;

            $("document").ready(function() {
                var tb = $('#tableB:eq(0) tbody');
                var size = tb.find("tr").length;
                tb.find("tr").each(function(index, element) {
                    var colSize = $(element).find('td').length;
                    let rowIndex = index + 1;

                    const obj = {};
                    $(element).find('td').each(function(index, element) {

                        var colVal = $(element).text();
                        dataArray.push(colVal.trim());
                        colIndex = index + 1;

                        if(rowIndex === i){
                            switch (colIndex){
                                case 1:
                                    obj['id'] = colVal.trim();
                                    break;
                                case 2:
                                    obj['name'] = colVal.trim();
                                    break;
                                case 3:
                                    obj['description'] = colVal.trim();
                                    break;
                                case 4:
                                    obj['stock'] = colVal.trim();
                                    break;
                                case 5:
                                    obj['price'] = colVal.trim();
                                    break;
                            }
                        }
                    });i++;
                    if(rowIndex !== 1){
                        arr.push(obj);
                    }
                });

                a = JSON.stringify(arr);

                console.log(a);

                document.getElementById("modifyData").innerHTML = a;
            });
        }

        var insertSave = false;
        var editSave = false;

        function checkTableEmpty(){
            if ($('#tableA tr').length == 1) {
                alert("Please add some item to this table!")
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body>
  <div class="mainInsertItemDiv">
    <div class="insertItemDiv">
      <div class="insertItemBox">
        <div class="insertItemBox">
          <div>
            <h1 style="text-align: center; font-size:50px;">Insert Item</h1>
          </div>
            <form name="insertForm" action="#">
          <div class="label">Item Name</div>
          <div><input type="text" class="textBox" id="name" name="name" required></div>
          <div class="label">Item Description</div>
          <div><textarea class="textBox" style="resize: vertical; " id="description" name="description" required></textarea></div>
          <div class="label">Stock Quantity</div>
          <div><input type="number" class="textBox" id="stockQuantity" name="stockQuantity" required></div>
          <div class="label">Price</div>
          <div><input type="number" class="textBox" id="price" name="price" required></div>
          <div class="label" style="margin:30px;"><input type="button" class="textBox" value="Insert to right table" onclick="if(insertItemIsEmpty()){ AddDataToTable(); getDataTophp(); insertSave = true;}  "></div>
            </form>
        </div>
      </div>
    </div>
    <div class="dataSaveInsertDiv">
        <form method="post" name="form" action="InsertItem.php">
            <textarea id="data" name="data" STYLE="display: none"></textarea>
            <input type="submit" value="Submit" class="itemButton" onclick="return checkTableEmpty()">
            <input type="button" value="Delete" class="itemButton" onclick="deleteRow(); getDataTophp();">
            <input type="button" value="Save Edit" class="itemButton" onclick="getDataTophp();">
        </form>
      <table id="tableA">
        <tr>
          <th><input type='checkbox' id='selectAll' name="selectAll" onclick="selectAll(this)"/></th>
          <th>ID</th>
          <th>Item Name</th>
          <th>Item Desctiption</th>
          <th>Stock Quantity</th>
          <th>Price</th>
        </tr>
          <tbody id="rows">
          </tbody>
      </table>
        <?php
        include "../conn.php";

        if(isset($_POST['data'])){
            $jsonData= $_POST['data'];; // put here your json object
            $array = json_decode($_POST['data'], true);

            if (isset($array)) {
                for($column = 0; $column < count($array); $column++){

                    $GetID = "SELECT max(itemID) FROM item";
                    $DoingGetID = mysqli_query($conn, $GetID) or die (mysqli_error($conn));
                    $IDRecord = mysqli_fetch_assoc($DoingGetID);
                    extract($IDRecord);
                    $id = (max($IDRecord))+1;

                    //$id = $array[$column]['id'];
                    $name = $array[$column]['name'];
                    $description = $array[$column]['description'];
                    $stock = $array[$column]['stock'];
                    $price = $array[$column]['price'];

                    $sql = "INSERT INTO item (itemID, itemName, itemDescription, stockQuantity, price) VALUES ('".$id."', '".$name."', '".$description."','".$stock."','".$price."')";
                    mysqli_query($conn, $sql);

                }
            }
        }

        mysqli_close($conn);
        ?>

    </div>
    <div class="dataItemStorgeDiv">
        <div><h1>Edit Item</h1></div>
        <form method="post" name="form" action="InsertItem.php">
            <textarea id="modifyData" name="modifyData" style="display:none;"></textarea>
            <script>


            </script>
            <input type="button" value="Save Edit" class="itemButton" onclick="modifyTophp(); editSave = true;">
            <input type="submit" value="Submit" class="itemButton" onclick="if(!editSave){alert('Please save edit first!')} return editSave;">
        </form>

        <table id="tableB" name="tableB">
            <tr>
                <th id="TableBDCol">ID</th>
                <th id="TableBDCol">Item Name</th>
                <th id="TableBDCol">Item Desctiption</th>
                <th id="TableBDCol">Stock Quantity</th>
                <th id="TableBDCol">Price</th>
            </tr>

            <tbody id="rows">
                <?php
                include "../conn.php";

                if(isset($_POST['modifyData'])){
                    $jsonDataB = $_POST['modifyData'];
                    $arrayB = json_decode($_POST['modifyData'], true);

                    if (isset($arrayB))
                    {
                        for($column = 0; $column < count($arrayB); $column++){

                            $id = $arrayB[$column]['id'];
                            $name = $arrayB[$column]['name'];
                            $description = $arrayB[$column]['description'];
                            $stock = $arrayB[$column]['stock'];
                            $price = $arrayB[$column]['price'];

                            //print_r($id." ".$name."<br>");
                            $sql = "UPDATE item SET itemName='".$name."', itemDescription = '".$description."', stockQuantity = '".$stock."', price = '".$price."' WHERE itemID='".$id."'";
                            //$sql = "INSERT INTO item (itemID, itemName, itemDescription, stockQuantity, price) VALUES ('".$id."', '".$name."', '".$description."','".$stock."','".$price."')";
                            mysqli_query($conn, $sql);
                        }
                    }
                }

                $sql = "SELECT * from item ORDER BY itemID ASC";
                $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                if(mysqli_num_rows($rs) > 0){
                    while($row = mysqli_fetch_assoc($rs)){
                        echo "<tr>
                                <td id='TableBDdata' contenteditable='true' >".$row["itemID"]."</td>
                                <td id='TableBDdata' contenteditable='true' >".$row["itemName"]."</td>
                                <td id='TableBDdata' contenteditable='true' >".$row["itemDescription"]."</td>
                                <td id='TableBDdata' contenteditable='true' >".$row["stockQuantity"]."</td>
                                <td id='TableBDdata' contenteditable='true' >".$row["price"]."</td>
                            </tr>";
                    }
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
  </div>

</body>

</html>
