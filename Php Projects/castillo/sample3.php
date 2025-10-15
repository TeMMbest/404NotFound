
<!--php super global variable-->
<!-- this variables are always accesible regardless of the scope-->
<!-- $_SERVER a super global variable that hold the information-->
<!-- about the header path, script, location and other info.-->
<!-- $_POST form method "post" global var that collects data from a from-->
<!-- $_GET form method "get"   session_name-->
<!-- $_FILES double dim array and keeps the file info related to-->
<!--uploaded file-->
<!-- $_SESSION associated with session variable.-->


<html>
    <head>
        <title> Example 3 </title>
        </head>
        <body>
            <form method = "POST" action = "">
              <h2> Example 3 </h2>

              Full Name: <input type = "text" name = "full_name"/>
              Age: <input type = "int" age = "Age"/>
              <input type = "submit" age = "display" value = "Display Age"/>
              <input type = "submit" name = "display" value = "Display Name"/>
                          
              </p>  
              
              <?php
              if(isset($_POST['display'])) 
                
                {
                echo "" .$_POST['full_name'];
              }


              ?>

   </form>
</body>


