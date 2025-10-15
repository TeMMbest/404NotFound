<html>
    <head>
        <title>PHP Example 2</title>

        </head>
        <body>
              <?php

               $a = 10;
               $b = 11;
               $c = $a + $b;

               echo " The sum of ". $a ." and ". $b ." is ". $c;

               $intvar = 123;
               $intvar2 = 123 + 456;
               echo $intvar;
               echo "</p>";
               echo $intvar2 . "</p>";
               $doub = 123.45;
               echo $doub . "</p>";
               
               echo "This is an example of single qouted string.</p>";
               echo " This is an example of single qouted string </p>";

               $str1 = 'This is an example of single qouted string.<br/>';
               $str2 = 'This is an example of single qouted string.<br/>';
               
               define("age",25);
               echo age . "</p>";
               echo constant ("age");
               ?>
</body>
</html>
