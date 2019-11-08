<?php

$test_case = [];

$test_case[] = 'oliward';			
$test_case[] = '@MR_BUBBLES';		
$test_case[] = '@hashtag%warrior';
$test_case[] = '@oli@wRTS';
$test_case[] = '@skfkfwo-.,[]=0+><^?';
$test_case[] = '-^?';

foreach($test_case AS $test_input){
    $test_output = twitter_cleaner($test_input);

    echo "twitter_cleaner: $test_input ---> $test_output <br/><br/>";
}

foreach($test_case AS $test_input){
    $test_output = twitter_address_name($test_input);

    echo "twitter_address_name: $test_input ---> $test_output <br/><br/>";
}

foreach($test_case AS $test_input){
    $test_output = twitter_address_home($test_input);

    echo "twitter_address_home: $test_input ---> $test_output <br/><br/>";
}

//functions here

function twitter_cleaner($input){
    //1)convert to lowercase
    $output = strtolower($input);
    //2)no weired chars 
    // $output = preg_replace('/[~!@#$%^&*()%@<>?]/', "" , $output); 
    // block list approach - declare what you don't want - less efficient.
    $output = preg_replace('/[^a-z0-9_]/', "" , $output); // '/[\W]/'
    
    //3)leading @ on all cases
    $output = str_replace($output,"@$output",$output);
    //$output = "@$output" 그냥 아웃풋에 @ concat 할수 도 있음.

    // $output = strtolower(preg_replace('/[^a-zA-Z0-9 -]/', "" , $output)str_replace($output,"@$output",$output),,,$input);

    return $output;
}

function twitter_address_name($input){
    $twitter = 'http://twitter.com/';
    //convert to lowercase
    $output = strtolower($input);
    //no weired chars
    $output = preg_replace('/[\W]/', "" , $output);
    // $output = str_replace($output, "$twitter$output" , $output);

    return "$twitter$output";
}

function twitter_address_at($input){
    $twitter = 'http://twitter.com/';
    //convert to lowercase
    $output = strtolower($input);
    //no weired chars
    $output = preg_replace('/[~!@#$%^&*()%@<>?]/', "" , $output);
    $output = str_replace($output, "$twitter@$output" , $output);

    return $output;
}

function twitter_address_home($input){
    $twitter = 'http://twitter.com/';
    //convert to lowercase
    $output = strtolower($input);
    //no weired chars
    $output = preg_replace('/[~!@#$%^&*()%@<>?]/', "" , $output);
    $output = str_replace($output, "$twitter$output#home" , $output);

    return $output;
}