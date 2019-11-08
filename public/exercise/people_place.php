<?php

$where_people_live = [
    // only one value for one key! index collision 

    'Kit' => 'Bedminister',
    'Oli' => 'Bedminister',
    'Gareth' => 'Monthpelier',
    'Claudia' => 'Easton'
];

var_dump($where_people_live); // print the array

//array name AS index(key) => value

foreach ($where_people_live AS $people => $place){
    // echo "$people lives in $place";
    // echo $people . ' lives in ' . $place . '<br/>';
    echo "$people lives in $place <br/>";
}
