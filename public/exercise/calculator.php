<?php
var_dump($_GET); // let's debug

$answer = '?';

if ($_GET) {

    if ($_GET['number1'] && $_GET['number2']){
        $output1 = $_GET['number1'];
        $output2 = $_GET['number2'];

        if($_GET['cal'] === 'add'){
            $answer = $output1 + $output2;
        }elseif ($_GET['cal'] === 'subst'){
            $answer = $output1 - $output2;
        }elseif ($_GET['cal'] === 'multi'){
            $answer = $output1 * $output2;
        }elseif ($_GET['cal'] === 'divi'){
            $answer = $output1 / $output2;
        }
        // else{
        //     echo "please enter sensible numbers!";
        // } -- not needed?
    }
}

?>

<!-- // what is isset? why need it? -->

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
    <input type = "submit" value= "Calulate" />

</form>

