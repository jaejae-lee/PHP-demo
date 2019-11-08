<?php
include('database.php');

/*
1.Form -> see calc forms 
2.PHP form handling -> submit work?
3.Check user input  -> email and password validation check 
4.Create an activation code -> requirment?
4.Save in database (will need to CREATE TABLE first)
5.Send email
6.Account creation success message */

$email = '';
$password = '';
$comment = '';

$error = false; // assume no problem
// $error_message = []; // can store in an arr 
$success = false;


if($_POST){
    var_dump($_POST);
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    //set the password rule
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $number    = preg_match('/[0-9]/', $password);
    $specialChars = preg_match('/[^\w]/', $password);

    //email validation func
    $emailcheck = filter_var($email, FILTER_VALIDATE_EMAIL);

    //Check email first 
    if(!$emailcheck) {
        $error = true;
        $comment =  "This is not a valid email 🧐";
        
    }
    elseif (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $error = true;
        $comment =  "Password rules!! 🤓 ☝ should be at least 8 characters 👉 include at least one upper case letter 👉  and a number 👉 one special character";
    }

     //check if there's the same email in database

     $query = "SELECT email FROM users WHERE email='".$email."' AND active='1'";
     $result = mysqli_query($db_connection, $query);

    if(mysqli_num_rows($result) > 0){
        //if email is already in the database
        $comment = 'You already have an account. Please log in <a class = "a" href ="login.php">here</a>';
    }
    

    //registration start here
    if (!$error){
        // activation code - unique (random), hard to guess (long, random)
        $activation_code = md5($email.time().rand(0,1000)); // Generate random 32 character hash and assign it to a local variable.

        // clean the users input - what this func do??
        $clean_email = mysqli_real_escape_string($db_connection, $email);

        $clean_password = mysqli_real_escape_string($db_connection, $password);

        $clean_activation_code = mysqli_real_escape_string($db_connection, $activation_code);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         // $hashed_password = hash("sha256", $password);

         
          /* query script that i used
         CREATE TABLE `users` (
            `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `username` VARCHAR( 255 ) NOT NULL ,
            `password` VARCHAR( 255 ) NOT NULL ,
            `email` TEXT NOT NULL ,
            `hash` VARCHAR( 255 ) NOT NULL ,
            `active` INT( 1 ) NOT NULL DEFAULT '0'
            ) ENGINE = MYISAM AUTO_INCREMENT=1;  */


            /*CREATE TABLE `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `email` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `activation code` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
            */

        $query = "INSERT INTO users (`email`, `password`, `hash`) 
                VALUES('$clean_email', '$hashed_password', '$clean_activation_code')";

        $result = mysqli_query($db_connection, $query);

        if ($result){
            // query ran okay
            if (mysqli_affected_rows($db_connection) == 1){
                // and we changed 1 or more rows of data

                $success = true;

                // then, send the email
                //email variables 
                $to      = $email; 
                $subject = 'Account verification';
                $message = 
                '<p>Thanks for signing up!<br/>
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</p>

                <p>-------------------------------<br/>
                 Email: '.$email.'<br/>
                 Password: '.$password.'<br/>
                ----------------------------------</p>
                
                <p>Please click this link to activate your account:
                <a href="http://jae.box/activate.php?hash='.$activation_code.'">click here</a></p>'; //$link = 'http://jae.box/activate.php?hash='.urlencode($activation_code);'

                $headers = "From: Dev Me <team@example.com>\r\n";
                $headers .= "Reply-To: Help <help@example.com>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html;\r\n";

                mail($to, $subject, $message, $headers);

                $comment = 'Your account has been made, <br /> please check your email and click the link to activate your account';
            }else{
                $comment = 'Uh oh, query ran, but there was a problem.';
            }
        }else{
            $error = true;
            $comment = 'Uh oh, query didn\'t run! A problem with the query';
        }
    }
}

?>

<!DOCTYPE HTML>
<head>
    <link rel = "stylesheet" href = "styles/form.css" >
</head>

<body>
    <form action = "" method = "POST">

        <h1>Register</h1>

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
            <input class = "input" type = "email" name = "email" value="<?php if ($_POST) echo $_POST['email']; ?>" required />

            <label class = "label" for = "password">PASSWORD:</label>
            <input class = "input" type = "password" name = "password" value="<?php if ($_POST) echo $_POST['password']; ?>" required/>
        
            <input class = "btn" type = "submit" value= "CREATE ACCOUNT!" />

        <?php } ?>
      
    </form>

</body>

