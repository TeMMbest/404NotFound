<?php
<!DOCTYPE html>
<html>
<head>
    <title>PHP if else if sample</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin: 20px 0;
        }
        input[type="number"] {
            padding: 8px;
            font-size: 16px;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            font-size: 18px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>PHP if else if sample</h1>

    <form method="POST">
        <div class="form-group">
            <label for="grade">Enter Grade (0-100): </label>
            <input type="number" name="grade" id="grade" min="0" max="100" required>
        </div>
        <input type="submit" value="Check Grade">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if grade is set and is numeric
        if (isset($_POST['grade']) && is_numeric($_POST['grade'])) {
            $grade = $_POST['grade'];
            
            // Validate grade range
            if ($grade >= 0 && $grade <= 100) {
                if ($grade >= 98 && $grade <= 100) {
                    $remark = "With Highest Honors";
                    echo "<div class='result'>Grade: $grade - $remark (Passed)</div>";
                } 
                else if ($grade >= 95 && $grade < 98) {
                    $remark = "With High Honors";
                    echo "<div class='result'>Grade: $grade - $remark (Passed)</div>";
                }
                else if ($grade >= 90 && $grade < 95) {
                    $remark = "With Honors";
                    echo "<div class='result'>Grade: $grade - $remark (Passed)</div>";
                }
                else if ($grade >= 75 && $grade < 90) {
                    $remark = "Passed";
                    echo "<div class='result'>Grade: $grade - $remark</div>";
                }
                else {
                    $remark = "Failed";
                    echo "<div class='result error'>Grade: $grade - $remark</div>";
                }
            } else {
                echo "<div class='result error'>Invalid Input: Grade must be between 0 and 100</div>";
            }
        } else {
            echo "<div class='result error'>Invalid Input: Please enter a valid number</div>";
        }
    }
    ?>
</body>
</html>