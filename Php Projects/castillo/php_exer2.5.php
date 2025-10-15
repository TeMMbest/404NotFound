<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Exercise 2.5</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            
            background: url('money bg.jpg') no-repeat center fixed;
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
            color: #b80e0eff;
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
            color: #007bff;    
        }
        .result-value {
            color: #b80e0eff;
        }
            .result-item:nth-child(4) .result-value {
            color: #1dbe32ff; 
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
        <img src="Money heist.png" alt="Calculator Icon" class="corner-icon">
        <h2>Loan Calculator</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="amount">Amount Needed:</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0" 
                       value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="interest">Interest Rate:</label>
                <input type="number" id="interest" name="interest" step="0.01" min="0" 
                       value="<?php echo isset($_POST['interest']) ? htmlspecialchars($_POST['interest']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="period">Payment Period:</label>
                <input type="number" id="period" name="period" min="1" 
                       value="<?php echo isset($_POST['period']) ? htmlspecialchars($_POST['period']) : ''; ?>">
            </div>
            
            <input type="submit" name="compute" value="Compute">
        </form>
        
        <?php
        if (isset($_POST['compute'])) {
            $amount = floatval($_POST['amount']);
            $interest_rate = floatval($_POST['interest']);
            $period = intval($_POST['period']);
            if ($period <= 0) {
                $period = 1; // Prevent division by zero or negative periods. para di error pag walang amount na nilagay :)
            }
            
            // Calculate loan details using simple interest 100% formula. kasi gusto ko :)
            $loan_amount = $amount;
            $total_interest = ($amount * $interest_rate * $period) / 100;
            $total_payable = $loan_amount + $total_interest;
            $monthly_payable = $total_payable / $period;
            
            // Format numbers with 2 decimal places and comma separators kasi yung mga pera ganun :)
            $formatted_loan_amount = number_format($loan_amount, 2);
            $formatted_total_interest = number_format($total_interest, 2);
            $formatted_total_payable = number_format($total_payable, 2);
            $formatted_monthly_payable = number_format($monthly_payable, 2);
        } else {

            // Default values when form hasn't been submitted yet. Zeroes para di error pag di pa na submit :)
            $formatted_loan_amount = "0.00";
            $formatted_total_interest = "0.00";
            $formatted_total_payable = "0.00";
            $formatted_monthly_payable = "0.00";
        }
        ?>
        
        <div class="result">
            <div class="result-item">
                <span class="result-label">Loan Amount:</span> 
                <span class="result-value"><?php echo $formatted_loan_amount; ?></span>
            </div>
            <div class="result-item">
                <span class="result-label">Total Interest:</span> 
                <span class="result-value"><?php echo $formatted_total_interest; ?></span>
            </div>
            <div class="result-item">
                <span class="result-label">Total Payable:</span> 
                <span class="result-value"><?php echo $formatted_total_payable; ?></span>
            </div>
            <div class="result-item">
                <span class="result-label">Monthly Payable:</span> 
                <span class="result-value"><?php echo $formatted_monthly_payable; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
