<?php

$options = [
  PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_BOTH,
  PDO::ATTR_EMULATE_PREPARES=> false,
  PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
  PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
];

try{
    $pdo = new pdo( 'mysql:host=localhost; dbname=nhl_model',
                    'nhl_page_user',
                    'P$Qcy9~b6bNqn;Ks',
                    $options);
    //die(json_encode(array('outcome' => true)));
}
catch(PDOException $e){
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}