<?php
// Compute values para sa salary computation form below :)
$daysWorked = isset($_POST['days_worked']) ? (float) $_POST['days_worked'] : 0;
$ratePerDay = isset($_POST['rate_per_day']) ? (float) $_POST['rate_per_day'] : 0;

$gross = $daysWorked * $ratePerDay;
$deduction = $gross * 0.10; // 10% tax deduction ng gobyerno na kurap :(
$net = $gross - $deduction;

function format_money($amount) {
	return number_format((float) $amount, 2, '.', ',');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Exercise 2.6</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: url('coins bg.jpg') no-repeat center fixed;
            background-size: cover;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
        }
        h2 {
            text-align: center;
            color: #1dbe32ff;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #007bff;
        }
        .result-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .result-label {
            font-weight: bold;
            color: #555;
        }
        .result-value {
            color: #1dbe32ff;
        }
        .result-item:nth-child(2) .result-value {
            color: #b80e0ef5; 
        }
        .corner-icon {
            position: absolute;
            top: 0px;
            right: 16px;
            width: 110px;
            height: 110px;
            object-fit: cover;
            aspect-ratio: 1 / 1;
            border-radius: 8px;
        }
        .signature-name {
            position: absolute;
            top: 10px;
            left: 16px;
            font-size: 13px;
            font-family: 'Brush Script MT', cursive, Arial, sans-serif;
            color: #b80e0eff;
            opacity: 0.7;
            pointer-events: none;
            user-select: none;
            z-index: 2;
        }
    </style>
    </head>
<body>
    <div class="container">
        <span class="signature-name">Selwyn Castillo</span>
        <img src="give_money.png" alt="Calculator Icon" class="corner-icon">
        <h2>Salary Calculator</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="days_worked">Number of Days Work:</label>
                <input type="number" id="days_worked" name="days_worked" step="1" min="0" value="<?php echo htmlspecialchars($daysWorked); ?>">
            </div>

            <div class="form-group">
                <label for="rate_per_day">Rate Per Day:</label>
                <input type="number" id="rate_per_day" name="rate_per_day" step="0.01" min="0" value="<?php echo htmlspecialchars($ratePerDay); ?>">
            </div>

            <input type="submit" value="Compute">
        </form>

        <div class="result">
            <div class="result-item">
                <span class="result-label">Gross Salary:</span>
                <span class="result-value"><?php echo format_money($gross); ?></span>
            </div>
            <div class="result-item">
                <span class="result-label">Deduction:</span>
                <span class="result-value"><?php echo format_money($deduction); ?></span>
            </div>
            <div class="result-item">
                <span class="result-label">Net Salary:</span>
                <span class="result-value"><?php echo format_money($net); ?></span>
            </div>
        </div>
    </div>
</body>
</html>


