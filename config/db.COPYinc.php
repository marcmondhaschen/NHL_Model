<?php
/**
 * This file contains configuration information for the program's database connections.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 *
 */

/**
 * RawPSA database configuration options
 */
$rawPSAdatabase = 'mysql:host=localhost; dbname=nhl_api_remodel_rawpsa';    // database & schema
$rawPSAuser = 'nhl_api_remodel_RawPSA_user';                                // username
$rawPSApassword = 'SOME_PASSWORD_OF_YOUR_CHOOSING';                                       // password
$rawPSAoptions = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
];                                                                          // database connection options

/**
 * PSA database configuration options
 */
$PSAdatabase = 'mysql:host=localhost; dbname=nhl_api_remodel_psa';          // database & schema
$PSAuser = 'nhl_api_remodel_PSA_user';                                      // username
$PSApassword = 'SOME_PASSWORD_OF_YOUR_CHOOSING';                                          // password
$PSAoptions = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
];                                                                          // database connection options

/**
 * Production database configuration options
 */
$proddatabase = 'mysql:host=localhost; dbname=nhl_api_remodel';         // database & schema
$produser = 'nhl_api_remodel_production_user';                              // username
$prodpassword = 'SOME_PASSWORD_OF_YOUR_CHOOSING';                                         // password
$prodoptions = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
];                                                                          // database connection options

try {
    $rawPSAPDO = new pdo($rawPSAdatabase, $rawPSAuser,$rawPSApassword, $rawPSAoptions);
} catch (PDOException $e) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect to Raw PSA database. Check your '
        .'configuration settings.')));
}

try {
    $PSAPDO = new pdo($PSAdatabase, $PSAuser,$PSApassword, $PSAoptions);
} catch (PDOException $e) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect to PSA database. Check your '
        .'configuration settings.')));
}

try {
    $prodPDO = new pdo($proddatabase, $produser,$prodpassword, $prodoptions);
} catch (PDOException $e) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect to production database. Check your '
        .'configuration settings.')));
}