<?php
/**
 *
 */

$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
];

try {
    $pdo = new pdo('mysql:host=localhost; dbname=nhl_model', 'nhl_page_user',
        'SOME_PASSWORD_OF_YOUR_CHOOSING', $options);
} catch (PDOException $e) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}