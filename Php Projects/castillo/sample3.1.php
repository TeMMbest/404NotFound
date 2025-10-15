<?php
    
    $num1 = 0;
    $num2 = 0;
    $num0;

    ?>

    <doctype html>
    <html>
        <head> <title> Example 3.1 </title></head>
        <body>
            <form method = "POST" action = "">
                <h2> Example 3.1 </h2>
<?php
    if(isset($_POST['sum'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $sum = $num1 + $num2;
    }
?>

<!--Basically a calculator bu it only adds stuff-->
<p> Num1: <input type = "text" name = "num1" value = "<?=$num1;?>" /></p>
<p> Num2: <input type = "text" name = "num2" value = "<?=$num2;?>" /></p>

<p> Sum: <input type = "text" name = "sum" value = "<?=$sum;?>" /></p>

<input type = "submit" name = "add" value = "Add"/>

</form>
</body>
</html>


        