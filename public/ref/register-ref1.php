<?php
include('database.php');
/*
1) Form
2) PHP form handling
3) Check user input
*/


// set defaults
$email = '';
$password = '';

$error = false; // assuming no problem
$error_message = []; // empty array for error messages

$success = false;

if ($_POST){
    // submitted form
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ('' == $email){
        // no email!
        $error = true;
        $error_message[] = 'Please provide an email';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        // not like an email!
        $error = true;
        $error_message[] = 'Please provide a valid email';
    }

    if ('' == $password){
        // no password!
        $error = true;
        $error_message[] = 'Please provide an password';
    }
    
    if ($error == false){
        // continue on
       
        // 4) Create an activation code - requirements?
        // unique (random, long)
        // hard to guess (random, long)
        $activation_code = hash('sha256', 'oliward@gmail.com'.time().'sjkdlfjasldkj'.rand(0,100000));

        // 5) Save in database (will need to CREATE TABLE first)

        $clean_email = mysqli_real_escape_string($db_connection, $email);

        $clean_password = mysqli_real_escape_string($db_connection, $password);

        $clean_activation_code = mysqli_real_escape_string($db_connection, $activation_code);

        /*
        CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `activation code` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
        */
        $query = "INSERT INTO `users`
                (`email`, `password`, `activation code`)
                    VALUES
                ('$clean_email', '$clean_password', '$clean_activation_code');";
        $result = mysqli_query($db_connection, $query);

        if ($result){
            // query ran okay
            if (mysqli_affected_rows($db_connection) == 1){
                // and we changed 1 or more rows of data

                // 6) Send email

                $link = 'http://oli.box/activate.php?code='.urlencode($activation_code);

                $subject = 'Activate your account';
                
                $message = '<p>Hi</p>';
                $message .= '<p>Please activate your account by <a href="'.$link.'">clicking here</a></p>';

                $headers = "From: Dev Me <team@example.com>\r\n";
                $headers .= "Reply-To: Help <help@example.com>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html;\r\n";
                
                if (mail($email, $subject, $message, $headers)){
                    // sent mail
                    $success = true;
                }else{
                    // problem
                    $error = true;
                    $error_message[] = 'Something went wrong sending the email';
                }
            }else{
                // Uh oh, something went wrong
                $error = true;
                $error_message[] = 'Something went wrong with the database';
            }
        }else{
            // Uh oh, query didn't run! A problem with the query
            $error = true;
            $error_message[] = 'Something went wrong with the database';
        }
    }
}
?>
<form action="" method="POST">
    <h1>Register</h1>

    <?php
    if ($success){ ?>
        <h2>We've made your account!</h2>
        <p>Now check your email</p>
    <?php }else{
        if ($error == true){
            foreach($error_message AS $message){
                echo '<p class="error">'.$message.'</p>';
            }
        } ?>
        <p>Email: <input type="email" name="email" value="<?php echo $email; ?>" required></p>
        
        <p>Password: <input type="password" name="password" value="<?php echo $password; ?>" required></p>

        <p><input type="submit" value="Register"></p>
    <?php } ?> 
</form>