<?php
/**
 * This file contains the implementation for the NHL API ReModel's "ConferenceController" class.
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
 * The ConferenceController Class acts a controller for other classes which provide
 *  + calls to the NHL's open API for conference data
 *  + loads conference API data to a local MySQL 'persistent storage area' (PSA)
 *  + parses batched conference API data from the PSA into required updates for 'production analysis' MySQL tables
 *  + initializes 'conference' database for new installations
 *
 * @package NHL_API_ReModel
 */
class ConferenceController extends APICalls
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
    public function getConferenceList()
    {
        $result = $this->pdo->query("select `id`,`name`,`link`,`abbreviation`,`shortName`,`active` from `nhl_model`.`conferences` order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     */
    public function updateConferenceList()
    {
        $franchises_array = $this->APIWrapper("https://statsapi.web.nhl.com/api/v1/conferences",
                "conferences");
        $franchise_count  = count($franchises_array);

        $result = $this->pdo->query("delete from`nhl_model`.`conferences`;");

        for ($i = 0; $i < $franchise_count; ++$i) {
            if (is_numeric($franchises_array[$i]['id']) && is_string($franchises_array[$i]['name'])) {
                $query  = "insert into `nhl_model`.`conferences` (`id`,`name`,`link`,`abbreviation`,`shortName`,`active`) values (".
                    $franchises_array[$i]['id'].", '".
                    $franchises_array[$i]['name']."', '".
                    $franchises_array[$i]['link']."', '".
                    $franchises_array[$i]['abbreviation']."', '".
                    $franchises_array[$i]['shortName']."', ".
                    $franchises_array[$i]['active'].
                    ");";
                $result = $this->pdo->query($query);
            } else {
                echo "Error: While updating the franchises table, some of the data fetched from the NHL API appears to be corrupted.";
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