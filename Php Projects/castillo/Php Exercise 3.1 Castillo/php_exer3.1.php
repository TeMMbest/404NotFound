<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Exercise 3.1</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-image: linear-gradient(rgba(2,6,23,0.35), rgba(2,6,23,0.35)), url('moneyBG.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: var(--text);
            margin-bottom: 1.25rem;
            font-size: clamp(1.4rem, 3.5vw, 2rem);
        }
        .subtitle {
            text-align: center;
            color: var(--muted-text);
            margin-top: -0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: var(--muted-text);
        }
        input[type="text"], input[type="number"], select { 
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }

        button,
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            padding: 10px 30px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
            min-width: 200px;
        }

        button:hover,
        input[type="submit"]:hover {
            background: #45a049;
        }
        .results {
            background-color: #fafafa;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-top: 15px;
        }
        .result-line {
            margin: 8px 0;
            font-size: 0.9em;
            color: #333;
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }
        .result-label {
            color: #666;
            font-weight: 500;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 12px;
        }
        .helper {
            margin-top: 4px;
            font-size: 0.85rem;
            color: var(--muted-text);
        }
        .title-container {
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
            background: white;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .logo:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title-container">
            <img src="bank.png" alt="Bank Logo" class="logo">
            <h1>SALARY CALCULATOR</h1>
            <div class="subtitle">PHP Exercise 3.1</div>
        </div>
        <?php

        // 0 value ng kada status
        $days_worked = $gross_salary = $tax_rate = $deduction = $net_salary = 0;
        $employee_status = "Employee Status";
        $civil_status = "Civil Status";
        $error_message = "";

        // Pag pili ng worker status
        $emp_regular = $emp_probationary = $emp_casual = "";
        $civil_single = $civil_married = $civil_widow = $civil_broken = "";

        if(isset($_POST['compute'])) {

            // bilang ng days worked base sa input
            $days_worked = $_POST['days_worked'];
            if($days_worked == "" || !is_numeric($days_worked)) {
                $error_message = "Please enter a valid number of days.";
            } elseif($days_worked < 0) {
                $error_message = "Days cannot be negative.";
            } elseif($days_worked > 31) {
                $days_worked = 31;
            }

            // gross salary based sa employee status
            @$employee_status = $_POST['employee_status'];
            if($employee_status == "Regular") {
                $gross_salary = $days_worked * 500;
                $emp_regular = "selected";
            } elseif($employee_status == "Probationary") {
                $gross_salary = $days_worked * 400;
                $emp_probationary = "selected";
            } elseif($employee_status == "Casual") {
                $gross_salary = $days_worked * 300;
                $emp_casual = "selected";
            } else {
                $error_message = "Please select an employee status.";
            }

            // Tax rate ng kada civil status
            @$civil_status = $_POST['civil_status'];
            if($civil_status == "Single") {
                $tax_rate = 12;
                $civil_single = "selected";
            } elseif($civil_status == "Married") {
                $tax_rate = 10;
                $civil_married = "selected";
            } elseif($civil_status == "Widow") {
                $tax_rate = 7;
                $civil_widow = "selected";
            } elseif($civil_status == "Broken") {
                $tax_rate = 5;
                $civil_broken = "selected";
            } else {
                $error_message = "Please select a civil status.";
            }

            // Final calculations if no errors based sa taas
            if($error_message == "") {
                $deduction = $gross_salary * ($tax_rate / 100);
                $net_salary = $gross_salary - $deduction;
            }
        }
        ?>
        <?php if ($error_message !== ''): ?>
            <div class="error" role="alert"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="days_worked">No. of Days Worked</label>
                <input type="number" id="days_worked" name="days_worked" min="0" step="1" required
                       placeholder="e.g., 22"
                       value="<?=$days_worked;?>">
            </div>
            
            <div class="form-group">
                <label for="employee_status">Employee Status</label>
                <select id="employee_status" name="employee_status" required>
                    <option><?=$employee_status;?></option>
                    <option value="Regular" <?=$emp_regular;?>>Regular</option>
                    <option value="Probationary" <?=$emp_probationary;?>>Probationary</option>
                    <option value="Casual" <?=$emp_casual;?>>Casual</option>
                </select>
            </div>
            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <select id="civil_status" name="civil_status" required>
                    <option><?=$civil_status;?></option>
                    <option value="Single" <?=$civil_single;?>>Single</option>
                    <option value="Married" <?=$civil_married;?>>Married</option>
                    <option value="Widow" <?=$civil_widow;?>>Widow</option>
                    <option value="Broken" <?=$civil_broken;?>>Broken</option>
                </select>
            </div>
            
            <div class="button-container">
                <button type="submit" name="compute" class="compute-btn">Compute Salary</button>
            </div>
        </form>
        
        <div class="results" aria-live="polite">
            <div class="result-line">
                <span class="result-label">Gross Salary</span>
                <span><?=number_format($gross_salary, 2);?></span>
            </div>
            <div class="result-line">
                <span class="result-label">Tax Rate</span>
                <span><?=$tax_rate;?>%</span>
            </div>
            <div class="result-line">
                <span class="result-label">Tax Deduction</span>
                <span><?=number_format($deduction, 2);?></span>
            </div>
            <div class="result-line">
                <span class="result-label">Net Salary</span>
                <span><?=number_format($net_salary, 2);?></span>
            </div>
        </div>
    </div>
    <footer style="text-align: center;">
       © SELWYN CASTILLO 2025
    </footer>
</body>
</html>
