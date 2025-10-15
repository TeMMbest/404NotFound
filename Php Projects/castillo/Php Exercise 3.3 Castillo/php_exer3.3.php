<?php
// Pizza prices
$price_hawaiian = 100;
$price_hamcheese = 150;
$price_beef = 200;
$price_cheese_supreme = 250;

// Size prices
$price_solo = 0;
$price_double = 50;
$price_family = 70;
$price_barkada = 90;

// Topping prices
$price_topping_cheese = 10;
$price_topping_pepper = 15;
$price_topping_ham = 27;
$price_topping_pineapple = 25;
$price_topping_groundbeef = 30;

// My variables
$pizza_type = "";
$size = 'Select Size';
$quantity = 1;
$total = 0;
$toppings_list = "";
$pizza_hawaiian = $pizza_hamcheese = $pizza_beef = $pizza_cheese = "";

if(isset($_POST['compute'])) {

    // Get pizza selection 
    @$pizza_type = $_POST['pizza'];
    if($pizza_type == "Hawaiian") {
        $pizza_hawaiian = "checked";
        $total += $price_hawaiian;
    } elseif($pizza_type == "Ham & Cheese") {
        $pizza_hamcheese = "checked";
        $total += $price_hamcheese;
    } elseif($pizza_type == "Beef") {
        $pizza_beef = "checked";
        $total += $price_beef;
    } elseif($pizza_type == "Cheese Supreme") {
        $pizza_cheese = "checked";
        $total += $price_cheese_supreme;
    }

    // Process size
    $size = $_POST['size'] ?? 'Select Size';
    if($size == "Solo") {
        $total += $price_solo;
    } elseif($size == "Double") {
        $total += $price_double;
    } elseif($size == "Family") {
        $total += $price_family;
    } elseif($size == "Barkada") {
        $total += $price_barkada;
    }

    // Get toppings list 
    $toppings_list = isset($_POST['toppings_list']) ? $_POST['toppings_list'] : '';
    
    // Toppings selection
    if(isset($_POST['cheese'])) {
        $toppings_list .= "Cheese (+₱" . number_format($price_topping_cheese, 2) . ")\n";
        $total += $price_topping_cheese;
    }
    if(isset($_POST['pepper'])) {
        $toppings_list .= "Pepper (+₱" . number_format($price_topping_pepper, 2) . ")\n";
        $total += $price_topping_pepper;
    }
    if(isset($_POST['ham'])) {
        $toppings_list .= "Ham (+₱" . number_format($price_topping_ham, 2) . ")\n";
        $total += $price_topping_ham;
    }
    if(isset($_POST['pineapple'])) {
        $toppings_list .= "Pineapple (+₱" . number_format($price_topping_pineapple, 2) . ")\n";
        $total += $price_topping_pineapple;
    }
    if(isset($_POST['groundbeef'])) {
        $toppings_list .= "Ground Beef (+₱" . number_format($price_topping_groundbeef, 2) . ")\n";
        $total += $price_topping_groundbeef;
    }

    // Apply quantity
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    $total *= $quantity;
}
// Clear form
if(isset($_POST['clear'])) {
    $pizza_type = "";
    $size = 'Select Size';
    $quantity = 1;
    $total = 0;
    $toppings_list = "";
    $pizza_hawaiian = $pizza_hamcheese = $pizza_beef = $pizza_cheese = "";
}

// Error message
$error_message = '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Exercise 3.3: ALLEN'S PIZZA SHOP</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
           background-image: linear-gradient(rgba(2,6,23,0.35), rgba(2,6,23,0.35)), url('4464061.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
        }

        .panel { 
            background: white;
            padding: 15px;
            margin-bottom: 20px;
        }

        fieldset { 
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }

        legend { 
            padding: 0 10px;
            font-weight: bold;
        }

        .grid { 
            display: grid; 
            gap: 20px; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .section-title { 
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stack > label { 
            display: block;
            margin: 5px 0;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="radio"]:hover,
        input[type="checkbox"]:hover {
            border-color: var(--accent-hover);
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
        }

        .summary {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
        }

        .summary label { 
            display: block;
            margin-bottom: 5px;
        }

        .summary input,
        .summary textarea { 
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }

        .summary input[readonly] {
            background: #f5f5f5;
        }

        .actions { 
            margin: 15px 0;
        }

        button,
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }

        button:hover,
        input[type="submit"]:hover {
            background: #45a049;
        }

        .price-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .price-table th { 
            background: #f5f5f5;
            font-weight: bold;
            padding: 8px;
        }

        .price-table th, 
        .price-table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }

        .muted { 
            color: #666; 
        }

        header { 
            padding: 20px 0; 
            text-align: center;
        }

        .title-container {
            text-align: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }
         .logo:hover {
            transform: scale(1.05);
        }

        header h1 { 
            margin: 0 0 10px 0; 
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="panel">
        <div class="title-container">
            <img src="pizza-boy.png" alt="Pizza Logo" class="logo">
            <div>
                <h1>ALLEN'S PIZZARIA</h1>
                <p class="muted">PHP Exercise 3.3 &middot; Pizza Shop</p>
            </div>
        </div>
    </header>

    <form method="post">
        <fieldset>
            <div class="grid">
                <div class="col">
                    <div class="section-title">Pizza</div>
                    <div class="stack">
                        <div style="margin-bottom: 10px;">
                            <input type="radio" name="pizza" id="hawaiian" value="Hawaiian" <?=$pizza_hawaiian;?> />
                            <label for="hawaiian">Hawaiian - ₱100.00</label>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <input type="radio" name="pizza" id="hamcheese" value="Ham & Cheese" <?=$pizza_hamcheese;?> />
                            <label for="hamcheese">Ham & Cheese - ₱150.00</label>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <input type="radio" name="pizza" id="beef" value="Beef" <?=$pizza_beef;?> />
                            <label for="beef">Beef - ₱200.00</label>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <input type="radio" name="pizza" id="cheese" value="Cheese Supreme" <?=$pizza_cheese;?> />
                            <label for="cheese">Cheese Supreme - ₱250.00</label>
                        </div>
                    </div>

                    <div class="section-title" style="margin-top:10px;">Size</div>
                    <div class="stack">
                        <select name="size">
                            <option value=""><?=$size;?></option>
                            <option value="Solo" <?=$size === 'Solo' ? 'selected' : '';?>>Solo - Free</option>
                            <option value="Double" <?=$size === 'Double' ? 'selected' : '';?>>Double - Add ₱<?=number_format($price_double, 2);?></option>
                            <option value="Family" <?=$size === 'Family' ? 'selected' : '';?>>Family - Add ₱<?=number_format($price_family, 2);?></option>
                            <option value="Barkada" <?=$size === 'Barkada' ? 'selected' : '';?>>Barkada - Add ₱<?=number_format($price_barkada, 2);?></option>
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="section-title">Extra Toppings</div>
                    <div class="stack">
                        <label>
                            <input type="checkbox" name="cheese" id="cheese" value="Cheese">
                            Cheese - Add ₱<?=number_format($price_topping_cheese, 2);?>
                        </label><br/>
                        <label>
                            <input type="checkbox" name="pepper" id="pepper" value="Pepper">
                            Pepper - Add ₱<?=number_format($price_topping_pepper, 2);?>
                        </label><br/>
                        <label>
                            <input type="checkbox" name="ham" id="ham" value="Ham">
                            Ham - Add ₱<?=number_format($price_topping_ham, 2);?>
                        </label><br/>
                        <label>
                            <input type="checkbox" name="pineapple" id="pineapple" value="Pineapple">
                            Pineapple - Add ₱<?=number_format($price_topping_pineapple, 2);?>
                        </label><br/>
                        <label>
                            <input type="checkbox" name="groundbeef" id="groundbeef" value="Ground Beef">
                            Ground Beef - Add ₱<?=number_format($price_topping_groundbeef, 2);?>
                        </label><br/>
                    </div>
                </div>

                <div class="col summary">
                    <div class="summary-content">
                        <label>
                            <strong>Quantity:</strong>
                            <input type="number" name="quantity" value="<?=$quantity;?>" min="1">
                        </label>
                        <label>
                            <strong>Total Amount:</strong>
                            <input type="text" value="₱<?=number_format($total, 2);?>" readonly>
                        </label>
                    </div>

                    <div class="actions">
                        <input type="submit" name="compute" value="Compute Total" class="compute-btn" />
                        <input type="submit" name="clear" value="Clear Order" class="clear-btn" />
                    </div>

                    <div class="toppings-list">
                        <label><strong>Selected Toppings:</strong></label>
                        <textarea name="toppings_list" 
                                  rows="4" 
                                  style="width: 100%; resize: none;"
                        ><?=$toppings_list;?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </fieldset>

    <table class="price-table">
        <tr>
            <th>Pizza</th>
            <th>Price</th>
            <th>Size</th>
            <th>Add-on</th>
            <th>Extra Toppings</th>
            <th>Add-on</th>
        </tr>
        <tr>
            <td>Hawaiian</td><td>100</td>
            <td>Solo</td><td>+ 0</td>
            <td>Cheese</td><td>+ 10</td>
        </tr>
        <tr>
            <td>Ham &amp; Cheese</td><td>150</td>
            <td>Double</td><td>+ 50</td>
            <td>Pepper</td><td>+ 15</td>
        </tr>
        <tr>
            <td>Beef Supreme</td><td>200</td>
            <td>Family</td><td>+ 70</td>
            <td>Ham</td><td>+ 27</td>
        </tr>
        <tr>
            <td>Cheese Supreme</td><td>250</td>
            <td>Barkada</td><td>+ 90</td>
            <td>Pineapple</td><td>+ 25</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td>Ground Beef</td><td>+ 30</td>
        </tr>
    </table>
    <footer>
        © SELWYN CASTILLO 2025
    </footer>
</body>
</html>


