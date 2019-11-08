<?php

if ($_POST){
    // submitted form
    if ($_POST['name'] AND $_POST['email']){
        // all good, we have their email
        echo 'Thanks!';
    }else{
        echo 'Please fill in all fields.';
    }
}
​?>

<form action="" method="POST">
    <p>Name: <input type="text" name="name" value="<?php if ($_POST) echo $_POST['name']; ?>"></p>
    <p>Email: <input type="text" name="email" value="<?php if ($_POST) echo $_POST['email']; ?>"></p>
    <p><input type="submit" value="Submit this form"></p>
</form>






