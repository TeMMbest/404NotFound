<!DOCTYPE html>
<html>
     <head>
        <title>PHP else if sample</title>
    </head>
    <body>
        <form method="post" action="">
            <h2>if else sample 2</h2>

            <?php
            $ave=0;
            $remark=$pre=$mid=$end="";

            if(isset($_POST['compute'])){
                $pre = isset($_POST['prelim']) ? $_POST['prelim'] : 0;
                $mid = isset($_POST['midterm']) ? $_POST['midterm'] : 0;
                $end = isset($_POST['finals']) ? $_POST['finals'] : 0;

                $ave=($pre+$mid+$end)/3;

                if($ave > 95){
                    $remark="Excellent";
                } elseif ($ave >= 90 && $ave <= 95){
                    $remark="Very Excellent";
                } elseif($ave >= 86 && $ave <= 90){
                    $remark="Very good";
                } elseif($ave >= 80 && $ave < 85){
                    $remark="Above average";
                } elseif($ave >= 75 && $ave < 80){
                    $remark="Below average";
                } elseif($ave < 75 && $ave >= 50){
                    $remark="Very Failed";
                }
                
            }

            ?>

            <p> Prelim Grade: <input type="text" name="prelim" value="<?php echo $pre; ?>"/></p>
            <p> Midterm Grade: <input type="text" name="midterm" value="<?php echo $mid; ?>"/></p>
            <p> Finals Grade: <input type="text" name="finals" value="<?php echo $end; ?>"/></p>
            <p><input type="submit" name="compute" value="Compute"/></p>   
            <p> Average Grade: <?=number_format($ave,2)?> </br> 
            Remark: <?=$remark;?></br> 
            </p> 


        </form>
    </body>
</html>
         
