<!DOCTYPE html>
<html>
     <head>
        <title>Radio Button sample</title>
    </head>
    <body>
        <form method="post" action="">
            <h2>Radio Button sample</h2>
            
            <?php
            $n1=$n2=$res=0;
            $optr="?";
            $math_opt=$math_opt2=$math_opt3=$math_opt4="";
            if(isset($_POST['compute'])){
               @$math_opt = isset($_POST['math_opt'];
               $n1=$_POST['n1'];
               $n2=$_POST['n2'];
                if($math_opt == "Add"){
                     $res=$n1+$n2;
                     $optr="Addition";
                     $math_op1="checked";
                } elseif($math_opt == "Sub"){
                     $res=$n1-$n2;
                     $optr="Subtraction";
                     $math_opt2="checked";
                } elseif($math_opt == "Mul"){
                     $res=$n1*$n2;
                     $optr="Multiplication";
                     $math_opt3="checked";
                } elseif($math_opt == "Div"){
                     if($n2 != 0){wwwwww    
                          $res=$n1/$n2;
                          $optr="Division";
                          $math_opt4="checked";
                     } else {
                          $optr="No Operation Selected";
                     }
                }
                ?>
                <p>
                       Num1: <input type="text" name="n1" value="<?php echo $n1; ?>"/>
                <p>    Num2: <input type="text" name="n2" value="<?php echo
                <p>
                Select Math Operation:</br>
                    <input type="radio" name="math_opt" id="add" value="Add" <?php echo $math_opt1; ?>/>Add
                    <input type="radio" name="math_opt" id="sub" value="Sub" <?php echo $math_opt2; ?>/>Subtract
                    <input type="radio" name="math_opt" id="Mul" value="Mul" <?php echo $math_opt3; ?>/>Multiply
                    <input type="radio" name="math_opt" id="Div" value="Div" <?php echo $math_opt4; ?>/>Divide

                <input type="submit" name="compute" value="Compute"/>

                </form>
                </body>
                </html>

