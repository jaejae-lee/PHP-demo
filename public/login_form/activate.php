<?php
include('database.php');

// activate.php?hash={541949673d5981e3eb24386637890576};

if(isset($_GET['hash'])){
    // verify data
    $activation_code = mysqli_real_escape_string($db_connection, $_GET['hash']); 

    // SELECT * FROM users WHERE hash = 'f11dbed2003a9c774dd95d8dbb1ac382';
     // check the code --> DB find the record with that code
    $query = "SELECT * FROM users WHERE hash='$activation_code' AND active = '0'";

    $result = mysqli_query($db_connection, $query);

    // if (mysqli_num_rows($result) > 0){
    //     while($row = mysqli_fetch_assoc($result)){
    //         var_dump($row);
    //     }
    // }

    if (mysqli_num_rows($result) > 0){
        // We have a match, activate the account
        $query = "UPDATE users SET active='1' WHERE hash='$activation_code'";
        $result = mysqli_query($db_connection, $query);

        if ($result){
            // query ran okay
            if (mysqli_affected_rows($db_connection) == 1){
                // and we changed 1 or more rows of data
                echo '<div>Your account has been activated, you can now <a href="login.php">login</a></div>';
            }else{
                // error message
                echo '<div>query ran ok, but there is a problem.</div>';
            }
        }else{
            // error message
            echo '<div>query didn\'t run, some problem with database.</div>';
        }

    }else{
        // No match -> invalid url or account has already been activated.
        echo '<div>Your account has already been activated. Please login here <a href = "login.php">login here</a> </div>';
    }
    
}else{
    // Invalid approach
    echo '<div>Invalid approach, please use the link that has been send to your email.</div>';
}


 





?>