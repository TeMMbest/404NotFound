<?php
// Processor prices
$price_i9 = 18000;
$price_i7 = 15000;
$price_i5 = 13000;
$price_i3 = 10000;
$price_r9 = 16000;
$price_r7 = 14000;
$price_r5 = 12000;
$price_r3 = 9000;

// Ram prices
$price_ram_64 = 25000;
$price_ram_32 = 20000;
$price_ram_16 = 10000;
$price_ram_8 = 8000;
$price_ram_4 = 4000;
$price_ram_2 = 2000;

// Accessories prices
$price_keyboard = 3000;
$price_mouse = 2000;
$price_headset = 3500;
$price_webcam = 2500;
$price_mousepad = 1500;
$price_speakers = 4000;
$price_harddrive = 2500;
$price_flashdrive = 600;

// Default values
$processor_selected = "Select Processor";
$ram_selected = "Select RAM";
$accessories_list = "";
$total = 0;
$error_message = "";

// selections 
$proc_i9 = $proc_i7 = $proc_i5 = $proc_i3 = "";
$proc_r9 = $proc_r7 = $proc_r5 = $proc_r3 = "";
$ram_64 = $ram_32 = $ram_16 = $ram_8 = $ram_4 = $ram_2 = ""; 

// Pagprocess ng form submission
if(isset($_POST['compute'])) {
    $accessories_list = isset($_POST['accessories_list']) ? $_POST['accessories_list'] : '';

    // Get processor selections
    @$processor_selected = $_POST['processor'];
    if($processor_selected == "Intel i9") {
        $proc_i9 = "checked";
        $total += $price_i9;
    } elseif($processor_selected == "Intel i7") {
        $proc_i7 = "checked";
        $total += $price_i7;
    } elseif($processor_selected == "Intel i5") {
        $proc_i5 = "checked";
        $total += $price_i5;
    } elseif($processor_selected == "Intel i3") {
        $proc_i3 = "checked";
        $total += $price_i3;
    } elseif($processor_selected == "AMD Ryzen 9") {
        $proc_r9 = "checked";
        $total += $price_r9;
    } elseif($processor_selected == "AMD Ryzen 7") {
        $proc_r7 = "checked";
        $total += $price_r7;
    } elseif($processor_selected == "AMD Ryzen 5") {
        $proc_r5 = "checked";
        $total += $price_r5;
    } elseif($processor_selected == "AMD Ryzen 3") {
        $proc_r3 = "checked";
        $total += $price_r3;
    } else {
        $error_message = "Please select a processor.";
    }

    // Get Ram selection
    @$ram_selected = $_POST['ram'];
    if($ram_selected == "64 GB") {
        $ram_64 = "selected";
        $total += $price_ram_64;
    } elseif($ram_selected == "32 GB") {
        $ram_32 = "selected";
        $total += $price_ram_32;
    } elseif($ram_selected == "16 GB") {
        $ram_16 = "selected";
        $total += $price_ram_16;
    } elseif($ram_selected == "8 GB") {
        $ram_8 = "selected";
        $total += $price_ram_8;
    } elseif($ram_selected == "4 GB") {
        $ram_4 = "selected";
        $total += $price_ram_4;
    } elseif($ram_selected == "2 GB") {
        $ram_2 = "selected";
        $total += $price_ram_2;
    } else {
        $error_message = "Please select RAM capacity.";
    }

    // Accessories selection
    if(isset($_POST['keyboard'])) {
        $accessories_list .= "Gaming Keyboard (+₱" . number_format($price_keyboard, 2) . "), ";
        $total += $price_keyboard;
    }
    if(isset($_POST['mouse'])) {
        $accessories_list .= "Gaming Mouse (+₱" . number_format($price_mouse, 2) . "), ";
        $total += $price_mouse;
    }
    if(isset($_POST['headset'])) {
        $accessories_list .= "Gaming Headset (+₱" . number_format($price_headset, 2) . "), ";
        $total += $price_headset;
    }
    if(isset($_POST['webcam'])) {
        $accessories_list .= "Webcam (+₱" . number_format($price_webcam, 2) . "), ";
        $total += $price_webcam;
    }
    if(isset($_POST['mousepad'])) {
        $accessories_list .= "Mouse Pad (+₱" . number_format($price_mousepad, 2) . "), ";
        $total += $price_mousepad;
    }
    if(isset($_POST['speakers'])) {
        $accessories_list .= "Speakers (+₱" . number_format($price_speakers, 2) . "), ";
        $total += $price_speakers;
    }
    if(isset($_POST['harddrive'])) {
        $accessories_list .= "External Hard Drive 512 GB (+₱" . number_format($price_harddrive, 2) . "), ";
        $total += $price_harddrive;
    }
    if(isset($_POST['flashdrive'])) {
        $accessories_list .= "USB Flash Drive 32 GB (+₱" . number_format($price_flashdrive, 2) . "), ";
        $total += $price_flashdrive;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ALLEN's PC WORKSHOP</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-image: linear-gradient(rgba(2,6,23,0.35), rgba(2,6,23,0.35)), url('computerBG.jpg');
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
            max-width: 900px; 
            margin: 20px auto; 
            padding: 15px;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .panel { 
            background: white;
            padding: 15px;
            margin-bottom: 20px;
        }

        fieldset { 
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 8px;
            font-size: 0.9em;
            border-radius: 4px;
            background: #fafafa;
        }

        legend { 
            padding: 0 10px;
            font-weight: bold;
        }

        .grid { 
            display: grid; 
            gap: 15px; 
            grid-template-columns: repeat(2, 1fr);
            margin: 0;
            align-items: start;
        }

        .section-title { 
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stack > label { 
            display: block;
            margin: 2px 0;
            font-size: 0.9em;
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
            padding: 8px;
            margin-top: 10px;
            font-size: 0.9em;
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
            margin-top: 10px;
            border: 1px solid #ddd;
            font-size: 0.85em;
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
            padding: 10px 0; 
            text-align: center;
        }

        .title-container {
            text-align: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 5px;
        }
         
        .logo:hover {
            transform: scale(1.05);
        }

        header h1 { 
            margin: 0 0 10px 0; 
            font-size: 24px;
        }

        .options {
            display: grid;
            gap: 5px;
        }

        .options label {
            margin-bottom: 5px;
            display: block;
        }

        .ram-grid select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .total-amount {
            font-size: 1.2em;
            margin-top: 15px;
        }

        .accessories-summary {
            margin: 10px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }
    </style>
<?php
?>
    </head>

<body>
    <div class="container">
        <header class="panel">
            <div class="title-container">
                <img src="pngwing.com.png" alt="Computer Logo" class="logo">
                <div>
                    <h1>ALLEN'S PC WORKSHOP</h1>
                    <p class="muted">PHP Exercise 3.2 &middot; PHP PC Shop</p>
                </div>
            </div>
        </header>

        <form method="post">
            <fieldset>
                <div class="grid">
                    <?php if (!empty($error_message)) : ?>
                        <div class="errors">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

            <fieldset>
                <legend>Processor</legend>
                <div class="options">
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="intel_i9" value="Intel i9" <?=$proc_i9;?> style="margin-right: 10px;" />
                        <label for="intel_i9">Intel i9 - ₱18,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="intel_i7" value="Intel i7" <?=$proc_i7;?> style="margin-right: 10px;" />
                        <label for="intel_i7">Intel i7 - ₱15,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="intel_i5" value="Intel i5" <?=$proc_i5;?> style="margin-right: 10px;" />
                        <label for="intel_i5">Intel i5 - ₱13,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="intel_i3" value="Intel i3" <?=$proc_i3;?> style="margin-right: 10px;" />
                        <label for="intel_i3">Intel i3 - ₱10,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="amd_r9" value="AMD Ryzen 9" <?=$proc_r9;?> style="margin-right: 10px;" />
                        <label for="amd_r9">AMD Ryzen 9 - ₱16,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="amd_r7" value="AMD Ryzen 7" <?=$proc_r7;?> style="margin-right: 10px;" />
                        <label for="amd_r7">AMD Ryzen 7 - ₱14,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="amd_r5" value="AMD Ryzen 5" <?=$proc_r5;?> style="margin-right: 10px;" />
                        <label for="amd_r5">AMD Ryzen 5 - ₱12,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="radio" name="processor" id="amd_r3" value="AMD Ryzen 3" <?=$proc_r3;?> style="margin-right: 10px;" />
                        <label for="amd_r3">AMD Ryzen 3 - ₱9,000</label>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>RAM</legend>
                <div class="ram-grid">
                    <select name="ram">
                        <option><?=$ram_selected;?></option>
                        <option value="65 GB" <?=$ram_64;?>>64 GB - ₱25,000</option>
                        <option value="32 GB" <?=$ram_32;?>>32 GB - ₱20,000</option>
                        <option value="16 GB" <?=$ram_16;?>>16 GB - ₱10,000</option>
                        <option value="8 GB" <?=$ram_8;?>>8 GB - ₱8,000</option>
                        <option value="4 GB" <?=$ram_4;?>>4 GB - ₱4,000</option>
                        <option value="2 GB" <?=$ram_2;?>>2 GB - ₱2,000</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend>Accessories</legend>
                <div class="options">
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="keyboard" id="keyboard" value="Gaming Keyboard" style="margin-right: 10px;" />
                        <label for="keyboard">Gaming Keyboard - ₱3,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="mouse" id="mouse" value="Gaming Mouse" style="margin-right: 10px;" />
                        <label for="mouse">Gaming Mouse - ₱2,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="headset" id="headset" value="Gaming Headset" style="margin-right: 10px;" />
                        <label for="headset">Gaming Headset - ₱3,500</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="webcam" id="webcam" value="Webcam" style="margin-right: 10px;" />
                        <label for="webcam">Webcam - ₱2,500</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="mousepad" id="mousepad" value="Mouse Pad" style="margin-right: 10px;" />
                        <label for="mousepad">Mouse Pad - ₱1,500</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="speakers" id="speakers" value="Speakers" style="margin-right: 10px;" />
                        <label for="speakers">Speakers - ₱4,000</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="harddrive" id="harddrive" value="External Hard Drive 512 GB" style="margin-right: 10px;" />
                        <label for="harddrive">External Hard Drive 512 GB - ₱2,500</label>
                    </div>
                    <div style="margin-bottom: 10px; display: flex; align-items: center;">
                        <input type="checkbox" name="flashdrive" id="flashdrive" value="USB Flash Drive 32 GB" style="margin-right: 10px;" />
                        <label for="flashdrive">USB Flash Drive 32 GB - ₱600</label>
                    </div>
                </div>
            </fieldset>
            
            <div class="col summary">
                <div class="summary-content">
                    <label>
                        <strong>Total Amount:</strong>
                        <input type="text" value="₱<?=number_format($total, 2);?>" readonly>
                    </label>
                </div>

                <div class="actions">
                    <input type="submit" name="compute" value="Compute Total" class="compute-btn" />
                </div>

                <div class="accessories-list">
                    <label><strong>Selected Items:</strong></label>
                    <textarea name="accessories_list" 
                              rows="4" 
                              style="width: 100%; resize: none;"
                    ><?=$accessories_list;?></textarea>
                </div>
            </div>
        </div>
    </fieldset>

    <table class="price-table">
        <tr>
            <th>Processor</th>
            <th>Price</th>
            <th>RAM</th>
            <th>Price</th>
            <th>Accessories</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>Intel i9</td><td>₱<?=number_format($price_i9,2)?></td>
            <td>64 GB</td><td>₱<?=number_format($price_ram_64,2)?></td>
            <td>Gaming Keyboard</td><td>₱<?=number_format($price_keyboard,2)?></td>
        </tr>
        <tr>
            <td>Intel i7</td><td>₱<?=number_format($price_i7,2)?></td>
            <td>32 GB</td><td>₱<?=number_format($price_ram_32,2)?></td>
            <td>Gaming Mouse</td><td>₱<?=number_format($price_mouse,2)?></td>
        </tr>
        <tr>
            <td>Intel i5</td><td>₱<?=number_format($price_i5,2)?></td>
            <td>16 GB</td><td>₱<?=number_format($price_ram_16,2)?></td>
            <td>Gaming Headset</td><td>₱<?=number_format($price_headset,2)?></td>
        </tr>
        <tr>
            <td>Intel i3</td><td>₱<?=number_format($price_i3,2)?></td>
            <td>8 GB</td><td>₱<?=number_format($price_ram_8,2)?></td>
            <td>Webcam</td><td>₱<?=number_format($price_webcam,2)?></td>
        </tr>
        <tr>
            <td>AMD Ryzen 9</td><td>₱<?=number_format($price_r9,2)?></td>
            <td>4 GB</td><td>₱<?=number_format($price_ram_4,2)?></td>
            <td>Mouse Pad</td><td>₱<?=number_format($price_mousepad,2)?></td>
        </tr>
        <tr>
            <td>AMD Ryzen 7</td><td>₱<?=number_format($price_r7,2)?></td>
            <td>2 GB</td><td>₱<?=number_format($price_ram_2,2)?></td>
            <td>Speakers</td><td>₱<?=number_format($price_speakers,2)?></td>
        </tr>
        <tr>
            <td>AMD Ryzen 5</td><td>₱<?=number_format($price_r5,2)?></td>
            <td>16 GB</td><td>₱<?=number_format($price_ram_16,2)?></td>
            <td>External Hard Drive 512 GB</td><td>₱<?=number_format($price_harddrive,2)?></td>
        </tr>
        <tr>
            <td>AMD Ryzen 3</td><td>₱<?=number_format($price_r3,2)?></td>
            <td colspan="2"></td>
            <td>USB Flash Drive 32 GB</td><td>₱<?=number_format($price_flashdrive,2)?></td>
        </tr>
    </table>
</form>
        <aside class="panel summary">
            <h2>Order Summary</h2>
            <div class="summary-content">
                <p><strong>Selected Processor:</strong> <?=$processor_selected;?></p>
                <p><strong>Selected RAM:</strong> <?=$ram_selected;?></p>
                <p><strong>Accessories:</strong></p>
                <div class="accessories-summary">
                    <?php if($accessories_list): ?>
                        <p><?=rtrim($accessories_list, ", ");?></p>
                    <?php else: ?>
                        <p class="muted">No accessories selected</p>
                    <?php endif; ?>
                </div>
                <p class="total-amount"><strong>Total Amount:</strong> ₱<?=number_format($total, 2);?></p>
            </div>
        </aside>

    </div>
    </table>
     <footer>
        © SELWYN CASTILLO 2025
    </footer>
</body>
</html>
