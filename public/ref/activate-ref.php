<?php
include('database.php');

// set defaults
$code = '';

$error = false; // assuming no problem
$error_message = []; // empty array for error messages

$success = false;

// need the code from query string $_GET['code']
if (isset($_GET['code'])){
    $code = $_GET['code'];

    $clean_code = mysqli_real_escape_string($db_connection, $code);
    
    // check the code --> DB find the record with that code
    $query = "SELECT * FROM `users` WHERE `activation code` = '$clean_code'";
    $result = mysqli_query($db_connection, $query);
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        if ($row['account status'] == 'pending'){
            // good, not activated yet

            // all good, then we want to "activate" their account
            $query = "UPDATE `users` SET `account status` = 'active' WHERE `activation code` = '$clean_code';";
            $result = mysqli_query($db_connection, $query);
            if ($result){
                // query ran okay
                if (mysqli_affected_rows($db_connection) == 1){
                    // and we changed 1 or more rows of data
                    $success = true;
                }else{
                    // Uh oh, query didn't run! A problem with the query
                    $error = true;
                    $error_message[] = 'Something went wrong with the database';
                }
            }else{
                // Uh oh, query didn't run! A problem with the query
                $error = true;
                $error_message[] = 'Something went wrong with the database';
            }
        }else{
            $error = true;
            $error_message[] = 'You\'ve already activated your account, please <a href="login.php">login here</a>';
        }
    }else{
        $error = true;
        $error_message[] = 'Can\'t find your activation code. Try following the link again';
    }
}else{
    $error = true;
    $error_message[] = 'You don\'t have an activation code. Try following the link again.';
} ?>

<h1>Activate</h1>

<?php
if ($success == true){ ?>
    <h2 style="color:green;">Your account has been activated</h2>

    <p>Please <a href="login.php">click here to log in</a></p>
<?php }else{
    if ($error == true){
        foreach($error_message AS $message){
            echo '<p class="error">'.$message.'</p>';
        }
    }
}