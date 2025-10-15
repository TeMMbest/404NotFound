<?php

session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

if (isset($_POST['add'])) {
    $name = $_POST['full_name'] ?? '';
    $age = $_POST['age'] ?? '';
    if ($name && $age) {
        $_SESSION['students'][] = ['name' => $name, 'age' => $age];
    }
}

?>

<html>
    <head>
        <title> Modified version of Example 3 </title>

        <!-- Background Image CSS -->
        <style>

            body {
                background-image: url('backiee-330488-landscape.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                
                /*Change the text color*/
                color: white; 
            }

        </style>

    </head>
    <body>

        <form method="POST" action="">
            <h2> STUDENT RECORD </h2>
            Full Name: <input type="text" name="full_name" required />
            Age: <input type="number" name="age" required />
            <input type="submit" name="add" value="Add Student" />

        </form>
        <h3>Student List</h3>
        <table border="1">
            
            <tr>
                <th>Name</th>
                <th>Age</th>
            </tr>

            <?php foreach ($_SESSION['students'] as $student): ?>

            <tr>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= htmlspecialchars($student['age']) ?></td>
            </tr>

            <?php endforeach; ?>

        </table>
    </body>
</html>