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
            <label for="rate" class="high-label">Current Rates</label>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $rateSen = $_POST['rate'];

    $powerWh = $voltage * $current;
    $powerkWh = $powerWh / 1000;
    $rateRM = $rateSen / 100;
?>
<br>
<div class="result-info">
    <p>TOTAL POWER</p>
    <div class="value-box-horizontal">
        <div class="value-box"><?php echo $powerWh; ?> Wh</div>
        <div class="value-box"><?php echo $powerkWh; ?> kWh</div>
    </div>
    <p>RATE</p>
    <div class="value-box">RM<?php echo $rateRM; ?></div>
</div>
<br>
<div class="hour-table">
    <table id="tablePerHour" class="tablePerHour">
	<tr>
            <th>#</th>
            <th>Hour</th>
            <th>Energy (kWh)</th>
            <th>Total Rate (RM)</th>
        </tr>
        <?php
        for ($hour = 1; $hour <= 24; $hour++) {
            $energyPerHour = $powerkWh * $hour;
            $totalCostHour = number_format($energyPerHour * $rateRM, 2);
        ?>
            <tr>
                <td><?php echo $hour; ?></td>
                <td><?php echo $hour; ?></td>
                <td><?php echo $energyPerHour; ?></td>
                <td><?php echo $totalCostHour; ?></td>
            </tr>
        <?php } ?>
    </table>
</div><br>
<div class="day-table">
    <table id="tablePerDay" class="tablePerDay">
	<tr>
            <th>#</th>
            <th>Day</th>
            <th>Energy (kWh)</th>
            <th>Total Rate (RM) </th>
        </tr>
	<?php
	for ($day = 1; $day <= 7; $day++) {
            $energyPerDay = $powerkWh * 24 * $day;
            $totalCostDay = number_format($energyPerDay * $rateRM, 2);
        ?>
            <tr>
                <td><?php echo $day; ?></td>
                <td><?php echo $day; ?></td>
                <td><?php echo $energyPerDay; ?></td>
                <td><?php echo $totalCostDay; ?></td>
            </tr>
        <?php } ?>
    </table>
    <br>
</div>
<?php } ?>
</div>
</body>
</html>