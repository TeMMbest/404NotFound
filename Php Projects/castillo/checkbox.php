<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f8f8f8;
        }

        .checkbox-item:hover {
            background-color: #f0f0f0;
        }

        .buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .add-btn {
            background-color: #4CAF50;
            color: white;
        }

        .clear-btn {
            background-color: #f44336;
            color: white;
        }

        button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .selected-fruits {
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
            background-color: #e8f5e9;
        }

        .selected-fruits h3 {
            color: #2e7d32;
            margin-top: 0;
        }

        .fruit-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .fruit-list li {
            padding: 8px;
            margin: 5px 0;
            background-color: white;
            border-radius: 4px;
            border-left: 4px solid #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Fruit Selection</h2>
        
        <form method="post">
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Apple" id="apple">
                    <label for="apple">Apple</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Banana" id="banana">
                    <label for="banana">Banana</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Orange" id="orange">
                    <label for="orange">Orange</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Mango" id="mango">
                    <label for="mango">Mango</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Strawberry" id="strawberry">
                    <label for="strawberry">Strawberry</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" name="fruits[]" value="Grapes" id="grapes">
                    <label for="grapes">Grapes</label>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" name="add" class="add-btn">Add Selected Fruits</button>
                <button type="submit" name="clear" class="clear-btn">Clear List</button>
            </div>
        </form>

        <?php
        session_start();

        // Initialize the session array if it doesn't exist
        if (!isset($_SESSION['selected_fruits'])) {
            $_SESSION['selected_fruits'] = array();
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add']) && isset($_POST['fruits'])) {
                // Add new selections to the existing array
                $_SESSION['selected_fruits'] = array_unique(
                    array_merge($_SESSION['selected_fruits'], $_POST['fruits'])
                );
            }
            
            if (isset($_POST['clear'])) {
                // Clear the selected fruits array
                $_SESSION['selected_fruits'] = array();
            }
        }

        // Display selected fruits if any exist
        if (!empty($_SESSION['selected_fruits'])) {
            echo '<div class="selected-fruits">';
            echo '<h3>Selected Fruits:</h3>';
            echo '<ul class="fruit-list">';
            foreach ($_SESSION['selected_fruits'] as $fruit) {
                echo "<li>$fruit</li>";
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>