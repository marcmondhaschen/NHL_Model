<?php
/**
 * This file contains the implementation for the NHL API ReModel's "DivisionController" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Model\Models;

use PDO;

/**
 * The DivisionController Class acts a controller for other classes which provide
 *  + calls to the NHL's open API for division data
 *  + loads division API data to a local MySQL 'persistent storage area' (PSA)
 *  + parses batched division API data from the PSA into required updates for 'production analysis' MySQL tables
 *  + initializes 'division' database for new installations
 *
 * @package NHL_API_ReModel
 */
class DivisionController extends APICalls
{
    protected $pdo;

    /**
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     *
     * @return type
     */
    public function getDivisionList()
    {
        $result = $this->pdo->query("select `id`, `name`, `link`, `abbreviation`, `conference`, `active` from `nhl_model`.`divisions` order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    #TODO: build a function that grabs inactive as well as active divisions

    /**
     *
     */
    public function updateDivisionList()
    {
        #TODO: update this function to test for new division updates, without rewriting the entire list
        $divisions_array = $this->APIWrapper("https://statsapi.web.nhl.com/api/v1/divisions", "divisions");
        $result          = $this->pdo->query("delete from`nhl_model`.`divisions`;");
        foreach ($divisions_array as $division) {
            if (is_numeric($division['id']) && is_string($division['name'])) {
                $query = "insert into `nhl_model`.`divisions` (`id`,`name`,`link`,`abbreviation`,`conference`,`active`) values (".
                    $division['id'].", '".
                    $division['name']."', '".
                    $division['link']."', '".
                    $division['abbreviation']."', ".
                    $division['conference']['id'].", ".
                    $division['active'].
                    ");";

                $result = $this->pdo->query($query);
            } else {
                echo "Error: Some of the data fetched from the NHL API appears to be corrupted.";
            }
        }
    }

    /**
     *
     * @param type $callString
     * @param type $arrayElement
     */
    public function APIWrapper($callString, $arrayElement = NULL)
    {
        parent::APIWrapper($callString, $arrayElement);
    }
}