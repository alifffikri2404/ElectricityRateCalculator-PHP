<!DOCTYPE html>
<html>
<head>
    <title>Electricity Rates Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="tablePerHour.css">
    <link rel="stylesheet" type="text/css" href="tablePerDay.css">
    <link rel="stylesheet" type="text/css" href="buttonCalculate.css">
    <link rel="stylesheet" type="text/css" href="buttonClear.css">
    <link rel="stylesheet" type="text/css" href="fontLabel.css">
    <link rel="stylesheet" type="text/css" href="resultContainer.css">
</head>
<body>
<div class="container mt-5">
    <h2>Electricity Rates Calculator<br><br></h2>
    <form method="post" onsubmit="clearForm()">
        <div class="form-group">
            <label for="voltage" class="high-label">Voltage</label>
            <input type="text" 
                class="form-control" 
                name="voltage"
                id="volatge"
                placeholder="<?php if (isset($_POST['voltage'])) 
                    echo htmlspecialchars($_POST['voltage']); ?>" required>
            <label for="voltage" class="label">Voltage (V)</label>
        </div>
        <div class="form-group">
            <label for="current" class="high-label">Current</label>
            <input type="text" 
                class="form-control" 
                name="current"
                id="current"
                placeholder="<?php if (isset($_POST['current'])) 
                    echo htmlspecialchars($_POST['current']); ?>" required>
            <label for="current" class="label">Ampere (A)</label>
        </div>
        <div class="form-group">
            <label for="rate" class="high-label">Current Rate</label>
            <input type="text" 
                class="form-control" 
                name="rate"
                id="rate"
                placeholder="<?php if (isset($_POST['rate'])) 
                    echo htmlspecialchars($_POST['rate']); ?>" required>
            <label for="current" class="label">Unit (sen/kWh)</label>
        </div>
        <div style="text-align:center;">
            <button type="submit" 
                class="buttonCalculate">Calculate
            </button>
            <button type="button" 
                class="buttonClear"
                onclick="clearForm()">Reset
            </button>
        </div>
        </form>
    </form>
    <script>
        function clearForm() {
            document.getElementById('tablePerHour').style.display = 'none';
            document.getElementById('tablePerDay').style.display = 'none';
        }
    </script>
<?php
function calculatePower($voltage, $current){
    $powerWh = $voltage * $current;
    $powerkWh = $powerWh / 1000;

    return array('powerWh' => $powerWh,'powerkWh'=> $powerkWh);
}

function tableHour($rowHour, $hour){
    echo '<table class="tablePerHour">';
    echo '<tr>
            <th>#</th>
            <th>Hour</th>
            <th>Energy (kWh)</th>
            <th>Total Rate (RM)</th>
        </tr>';
    foreach($rowHour as $row){
        echo "<tr>
            <td>{$row['hour']}</td>
            <td>{$row['hour']}</td>
            <td>{$row['energyPerHour']}</td>
            <td>{$row['totalCostHour']}</td>
        </tr>";
    }
    echo '</table>';
}

function tableDay($rowDay, $day){
    echo '<table class="tablePerDay">';
    echo '<tr>
            <th>#</th>
            <th>Day</th>
            <th>Energy (kWh)</th>
            <th>Total Rate (RM) </th>
        </tr>';
        foreach($rowDay as $row){
            echo "<tr>
                <td>{$row['day']}</td>
                <td>{$row['day']}</td>
                <td>{$row['energyPerDay']}</td>
                <td>{$row['totalCostDay']}</td>
            </tr>";
        }
        echo '</table>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $rateSen = $_POST['rate'];

    $rateRM = $rateSen / 100;
    $powerArray = calculatePower($voltage, $current);
    $powerWh = $powerArray['powerWh'];
    $powerkWh = $powerArray['powerkWh'];

    echo "<br>
        <div class='result-info'>";
    echo "<p>TOTAL POWER</p>";
    echo "<div class='value-box-horizontal'>";
    echo "<div class='value-box'>$powerWh Wh</div>";
    echo "<div class='value-box'>$powerkWh kWh</div>";
    echo "</div>";
    echo "<p>RATE</p>";
    echo "<div class='value-box'>RM$rateRM</div>";
    echo "</div>";

    $rowHour = array();
    for ($hour = 1; $hour <= 24; $hour++) {
        $energyPerHour = $powerkWh * $hour;
        $totalCostHour = number_format($energyPerHour * $rateRM, 2);
        $rowHour[] = array('hour' => $hour, 'energyPerHour' => $energyPerHour, 'totalCostHour' => $totalCostHour);
    }

    echo '<br>
        <div class="hour-table">';
    tableHour($rowHour, 24);
    echo '</div>
        <br>';

    $rowDay = array();
    for ($day = 1; $day <= 7; $day++) {
        $energyPerDay = $powerkWh * 24 * $day;
        $totalCostDay = number_format($energyPerDay * $rateRM, 2);
        $rowDay[] = array('day' => $day, 'energyPerDay' => $energyPerDay, 'totalCostDay' => $totalCostDay);
    }

    echo '<br>
        <div class="day-table">';
    tableDay($rowDay, 7);
    echo '</div>
        <br>';
}
?>

</div>
</body>
</html>