<?php
var_dump($_GET); // let's debug

// set any defaults
$num1 = 0;
$num2 = 0;
$cal = 'add';
$answer = '?';


// if it has values execute these-
if($_GET){
    //overwrite variables
    $num1 = $_GET['number1'];
    $num2 = $_GET['number2'];
    $cal = $_GET['cal'];

    //do switch
    switch($cal){
        case 'add':
            $answer = $num1 + $num2;
        break;
        case 'subst':
            $answer = $num1 - $num2;
        break;
        case 'multi':
            $answer = $num1 * $num2;
        break;
        case 'divi':
            $answer = $num1 * $num2;
        break;
    }
}
?>


<form action = "" method = "GET">

    <input type = "number" name = "number1" value="<?php if ($_GET) echo $_GET['number1']; ?>"/>
    <select name = "cal">
        <option value="add">+</option>
        <option value="subst">-</option>
        <option value="multi">X</option>
        <option value="divi">/</option>
    </select>

    <input type = "number" name = "number2" value="<?php if ($_GET) echo $_GET['number2']; ?>"/>
    <span>=</span>
    <span> <?php echo $answer ?> </span>
    <input type = "submit" value= "Calulate!" />

</form>