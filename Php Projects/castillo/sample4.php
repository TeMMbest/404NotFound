<?php

$len = $wid = $area = 0;

if (isset($_POST['compute'])) {
    $len = $_POST['len'];
    $wid = $_POST['wid'];
    $area = $len * $wid;
}
?>

<!doctype html>

<html>
    <head>
        <title>Calculate the Area of Len/Wid</title>

    </head>
    <body>

        <form method="POST" action="">
            <h2> Calculate the Area of Len/Wid </h2>
            <p>Length: <input type="text" name="len" value="<?= $len; ?>"></p>
            <p>Width: <input type="text" name="wid" value="<?= $wid; ?>"></p>
            <p>Area: <input type="text" name="area" value="<?= $area; ?>" readonly></p>
            <input type="submit" name="compute" value="Compute">

        </form>
    </body>
</html>
