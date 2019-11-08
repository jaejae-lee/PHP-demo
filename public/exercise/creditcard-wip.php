<?php

$credit_card = [];

//test 
$credit_card[] = '41112222333344445';
$credit_card[] = '4111 2222 3333 4444';
$credit_card[] = '4111x2222x3333x4444';
$credit_card[] = '4111x2222x3333x4444';
$credit_card[] = '4111-2222-3333-4444';
$credit_card[] = '4111-2222-3333-4444-5555';

foreach($credit_card AS $credit_care_input){
    $credit_care_output = credit_card_cleaner($credit_care_input);

    echo  $credit_care_output;
}

function credit_card_cleaner($input){
   // remove weired char
    $output = preg_replace('/[^0-9]/', "" , $input);
    
    //get 4 nums
    foreach($output AS $num_output) {
        $num_output = substr($output, 0, 4);
        $num_output = "$num_output-";
    }
    return $output;
}
    
    


?>