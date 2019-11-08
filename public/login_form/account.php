<?php
include('database.php');

$_SESSION['logged_in'] = 'YES'; // ?????????

if (isset($_SESSION['logged_in'])){
    if ('YES' == $_SESSION['logged_in']){
        // they've logged in already
        echo 'Welcome to your account page!';
    }else {
        echo 'problem!';
    }

    if ($_POST){
        $email = mysqli_real_escape_string($db_connection, $_POST['email']);
        $query = "SELECT email FROM users WHERE email='".$email."' AND active='1'";
        $result = mysqli_query($db_connection, $query);
        $row = mysqli_fetch_assoc($result);  
        $email_account_print = $row['email']; 
    }
}

if ($_POST){
    //when logout btn clicked
    $submit = $_POST['submit'];

    if($submit == 'Logout!'){
        session_destroy();
        header("Location:login.php"); 
        exit;  // dont run the rest of code
    }
}

?>

<!DOCTYPE HTML>
<head>
    <link rel = "stylesheet" href = "styles/form.css" >
</head>

<body>
    

        <h1>My account</h1>

            <label class = "label" for = "email">EMAIL:</label>
            <input class = "input" type = "email" name = "email" value="<?php echo $email_account_print; ?>" />
    
    <form action = "" method = "POST">
        <input class = "btn" type = "submit" name = "submit" value= "Logout!">
    </form>

</body>