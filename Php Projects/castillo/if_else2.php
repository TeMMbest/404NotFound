<doctype html>
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
                $pre=$_POST['prelim'];
                $mid=$_POST['midterm'];
                $end=$_POST['endterm'];

                $ave=($pre+$mid+$end)/3;

                if($ave>=75)
                {
                    $remark="Failed";
                } elseif($ave>=75 and $ave<80){
                    $remark="Below average";
                } elseif($ave>=80 and $ave<85){
                    $remark="above average";
                } elseif($ave > 90){
                    $remark="excellent";
                }
                
            }

            ?>

            <p> Prelim Grade: <input type="text" name="prelim" value="<?php echo $pre; ?>"/></p>
            <p> Midterm Grade: <input type="text" name="midterm" value="<?php echo $mid; ?>"/></p>
            <p> Endterm Grade: <input type="text" name="endterm" value="<?php echo $end; ?>"/></p>
            <p> input type="submit" name="compute" value="Compute"/></p>   
            <p> Average Grade: <?=number_format($ave,2)?> </br> 
            Remark: <?=$remark;?></br> 
            </p> 


        </form>
    </body>
</html>
         
