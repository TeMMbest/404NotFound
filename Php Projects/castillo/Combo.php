<!DOCTYPE html>
<html>
     <head>
        <title>Combo sample</title>
    </head>
    <body>
        <form method="post" action="">
            <h2>Combo sample</h2>
            
            <?php
            $greet="";
            $lang="Language";
            if(isset($_POST['greet'])){
                $lang = isset($_POST['lang']) ? $_POST['lang'] : "Language";

                if($lang == "English"){
                    $greet="Good_Day!";
                } elseif($lang == "Tagalog"){
                    $greet="Maganda Araw!";
                } elseif($lang == "Spanish"){
                    $greet="Buen Dia!";
                } elseif($lang == "French"){
                    $greet="Bonne Journee!";    
                } elseif($lang == "German"){
                    $greet="Guten Tag!";
                } elseif($lang == "Bisaya"){
                    $greet="Maayong buntag!";
                } elseif($lang == "Chinese"){
                    $greet="Hao de yi tian!";
                }
                
            
                else {
                    $greet="Unknown Language";
                }
            }
            ?>
            <p>
                Select Language:
                <select name="lang">
                    <option><?=$lang;?></option>
                    <option value="English">English</option>
                    <option value="Tagalog">Tagalog</option>
                    <option value="Spanish">Spanish</option>
                    <option value="French">French</option>
                    <option value="German">German</option>
                    <option value="Bisaya">Bisaya</option>
                    <option value="Chinese">Chinese</option>
                </select>
            </p>
            <p><input type="submit" name="greet" value="Greet"/></p>
        </p>
        <p>> <?=$greet;?></p>
        </form>
    </body>
</html>