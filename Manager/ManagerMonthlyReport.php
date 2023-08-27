<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manager</title>
    <link rel="stylesheet" href="../CSS/designKenneth.css" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script type="text/javascript" src="../js/chartjs-plugin-colorschemes.js"></script>
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="mainDivReport">
    <div class="TopDiv">
        <div class="selectMonth">
            <form id="form1" name="form1" method="get" action="ManagerMonthlyReport.php">
                <input class="datePicker" id="datePicker" type="month" value="<?php if(isset($_GET['save'])){echo $_GET['save'];}?>" onclick="">
                <textarea id="save" name="save" style="display:none;"></textarea>
                <script>
                    $('#datePicker').change(function(){
                        console.log('Submiting form');
                        document.getElementById('save').innerHTML = document.getElementById('datePicker').value;
                        $('#form1').submit();
                    });
                </script>
            </form>

        </div>
        <div class="staffTableDiv">
            <table class="staffTable">
                <tr>
                    <th>Staff ID</th>
                    <th>Staff Name</th>
                    <th>Order Count</th>
                    <th>Monthly amount</th>
                </tr>
                <tbody>
                <?php
                include "../conn.php";

                if(isset($_GET['save'])) {
                    //$time = strtotime("2010.12.11");
                    $startMonth = date('Y-m-d H:i:s', strtotime($_GET['save']));

                    $endMonth = strtotime($startMonth);
                    $endMonth = date('Y-m-d H:i:s', strtotime("+1 month", $endMonth));

                    $sql = "select s.staffID as a, s.staffName as b, COUNT(o.staffID) as c, SUM(o.orderAmount) as d
                        from orders as o
                        inner join staff as s
                        on o.staffID = s.staffID
                        WHERE o.dateTime >= '" . $startMonth . "' AND o.dateTime < '" . $endMonth . "'
                        GROUP BY s.staffID
                        Order BY s.staffID ASC;";

                    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));


                    $total = 0;

                    $name = array();
                    $amount = array();
                    if (mysqli_num_rows($rs) > 0) {
                        while ($row = mysqli_fetch_assoc($rs)) {
                            echo "<tr>
                                <td id='TableBDdata' >" . $row["a"] . "</td>
                                <td id='TableBDdata' >" . $row["b"] . "</td>
                                <td id='TableBDdata' >" . $row["c"] . "</td>
                                <td id='TableBDdata' >" . $row["d"] . "</td>
                            </tr>";

                            array_push($name, $row["b"]);
                            array_push($amount, $row["d"]);

                            $total += $row["d"];
                        }
                    }

                ?>

                </tbody>

            </table>
        </div>
    </div>
    <div class="DownDiv">
        <div class="DownLeftDiv">
            <div class="chartTitle">
                <h1 style="text-align:center;">Total Sales Amount: <?php $row = mysqli_fetch_assoc($rs); echo $total;?></h1>
            </div>
            <div class="chartDiv">
                <canvas id="myChart" class="" style="width:100%; height: 100%; display: block;"></canvas>
                <script>
                    var staffName = [
                        <?php

                        for($i = 0; $i < count($name); $i++){
                            echo "'".$name[$i]."',";
                        }?>];

                    var amount = [
                        <?php
                        for($i = 0; $i < count($amount); $i++){
                            echo "".$amount[$i].",";
                        }?>];

                    var barColors = [
                        "#b91d47",
                        "#00aba9",
                        "#2b5797",
                        "#e8c3b9",
                        "#1e7145"
                    ];



                    new Chart("myChart", {
                        type: "pie",
                        data: {
                            labels: staffName,
                            datasets: [{
                                label: '# of Votes',
                                data: amount,

                            }]
                        },
                        options: {
                            plugins: {
                                colorschemes: {
                                    scheme: 'office.Grid6'
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
        <div class="DownRightDiv">
            <div class="rankingTitle">
                <h1 style="text-align:center;">Ranking</h1>
            </div>
            <div class="ranking">
                <table>
                    <tr>
                        <th>Rank</th>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                    </tr>
                    <tbody>
                    <?php

                    $sql = "select s.staffID as a, s.staffName as b, COUNT(o.staffID) as c, SUM(o.orderAmount) as d
                        from orders as o
                        inner join staff as s
                        on o.staffID = s.staffID
                        WHERE o.dateTime >= '" . $startMonth . "' AND o.dateTime < '" . $endMonth . "'
                        GROUP BY s.staffID
                        Order BY d DESC ;";

                    $rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));

                    $i = 1;
                    if(mysqli_num_rows($rs) > 0){
                        while($row = mysqli_fetch_assoc($rs)){
                            echo "<tr>
                                <td id='TableBDdata' >".$i."</td>
                                <td id='TableBDdata' >".$row["a"]."</td>
                                <td id='TableBDdata' >".$row["b"]."</td>
                            </tr>";
                            $i++;
                        }
                    }
                    }
                    ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>
