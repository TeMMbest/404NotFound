<?php
//switch example
$color = "blue";
switch ($color) {
    case "red":
        echo "Your favorite color is blue.";
        break;
    case "blue":
        echo "Your favorite color is red.";
        break;
    case "green":
        echo "Your favorite color is green.";
        break;
    default:
        echo "Undefined color!";
}
echo "<br>This is while loop example:<br>";
$num = 1;
while ($num <= 6) {
    echo $num;
    $num++;
}
echo "<br>This is do while loop example:<br>";
$num2 = 5;
do {
    echo $num2;
    $num2++;
} while ($num2 <= 10);

echo "<br>This is for loop example:<br>";
for ($n = 0; $n <= 10; $n++) {
    if($n == 3) break;
    echo "The number is :" . $n . "<br>";
}
echo "<br>This is foreach loop example:<br>";
$colors = array("red", "green", "blue", "yellow");
foreach ($colors as $color) {
    echo $color . "<br>";
}

echo "<br> Array indexed example:<br>";
$cars = array("Honda", "BMW", "Toyota", "Audi", "Ford","Chevrolet");
echo $cars[0];
echo "<br>";
echo $cars[3];
echo "<br>";

$fruits=array("mango","banana","orange","grape","apple");
foreach($fruits as $fruit){
    echo "I Like $fruit<br>"; 
}
echo "<br> Associative array example:<br>";
$student = array("name" => "Allysa", "age" => 20, "major" => "InfoTech");
echo $student["name"]; // Outputs: Allysa

echo "<br>Associative array example 3:<br>";
$product = array("id" => "P101", "name" => "Wireless Mouse", "price" => 500);

echo "<br> Associative array example:<br>";
$student = array("name" => "Allysa", "age" => 20, "major" => "InfoTech");
foreach($student as $st => $data)
echo "$st: $data<br>";
?>