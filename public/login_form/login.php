<?php
include('database.php');

$comment = '';

$error = false;
$success = false;

if($_POST){
    // if form submitted
    echo '<div>'.$comment.'</div>';

    $email = mysqli_real_escape_string($db_connection, $_POST['email']); // Set variable for the id(email)

    //because we stored hased password in database...
    $password = $_POST['password'];

    //find the user's hash password query
    $query = "SELECT password FROM users WHERE email='".$email."' AND active='1'";
    //run the query
    $result = mysqli_query($db_connection, $query); //this is a result 'object' 
    // var_dump ($result); 

   

    if (mysqli_num_rows($result) > 0){
        //if we have user's id in database
       
        $row = mysqli_fetch_assoc($result);  // return an array. key = field name 
        $password_from_database = $row['password']; // assign hased pw as string into a variable

        // echo $password;
        // echo $password_from_database;

            //check password
        if (password_verify($password, $password_from_database)){
            // if password match 
        
            $success= true;

            $comment = 'you\'re logged in';

            session_start(); // start session
            $_SESSION['logged_in'] = 'YES'; // use session

            header("Location: account.php"); //link to account page
            exit;  // dont run the rest of code

        }else {
            $error = true;
            $comment = 'wrong password, try again';
        }
    }else {
        $error = true;
        //there's no such id - register first
        $comment = 'Please create an account first';
    }
        
}
?>

<!DOCTYPE HTML>
<head>
    <link rel = "stylesheet" href = "styles/form.css" >
</head>

<body>
    <form action = "" method = "POST">

        <h1>Login</h1>

        <?php
        if($success){ 
            echo '<p>success!</p>';
            echo '<p>'.$comment.'</p>';
        }else {
            if ($error){
                echo '<p>Sorry there was a problem</p>';
                echo '<p>'.$comment.'</p>';
            }?>

            <label class = "label" for = "email">EMAIL:</label>
            <input class = "input" type = "email" name = "email" value="<?php if ($_POST) echo $_POST['email']; ?>" placeholder = "email@email.com"required />

            <label class = "label" for = "password">PASSWORD:</label>
            <input class = "input" type = "password" name = "password" value="<?php if ($_POST) echo $_POST['password']; ?>" required/>
        
            <input class = "btn" type = "submit" value= "Login!" />
            <a class = "a" href ="register.php">Create an account</a>

        <?php } ?>
      
    </form>

</body>


