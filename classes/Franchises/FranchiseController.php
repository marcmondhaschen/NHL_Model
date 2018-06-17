<?php
/**
 * This file contains the implementation for the NHL API ReModel's "FranchiseController" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 *
 * NOTES ON FRANCHISE DATA :
 * + Franchises are associated to teams by mostRecentTeamId
 *
 */

namespace NHL_API_Remodel\Models;

use PDO;

include 'classes/APICalls.php';
/**
 * The FranchiseController Class acts a controller for other classes which provide
 *  + calls to the NHL's open API for franchise data
 *  + loads franchise API data to a local MySQL 'persistent storage area' (PSA)
 *  + parses batched franchise API data from the PSA into required updates for 'production analysis' MySQL tables
 *  + initializes 'franchise' database for new installations
 *
 * @package NHL_API_ReModel
 */
class FranchiseController extends APICalls
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
    public function getFranchiseList()
    {
        $result = $this->pdo->query("select `franchiseId`,`firstSeasonId`,`mostRecentTeamId`,`teamName`,`locationName`,`link` from `nhl_model`.`franchises` order by `teamName`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     */
    public function updateFranchiseList()
    {
        $franchises_array = $this->APIWrapper("https://statsapi.web.nhl.com/api/v1/franchises", "franchises");
        $result = $this->pdo->query("delete from`nhl_model`.`franchises`;");
        foreach ($franchises_array as $franchise) {
            if (is_numeric($franchise['franchiseId']) && is_string($franchise['teamName'])) {
                $query  = "insert into `nhl_model`.`franchises` (`franchiseId`,`firstSeasonId`,`mostRecentTeamId`,`teamName`,`locationName`,`link`) values (".
                    $franchise['franchiseId'].", '".
                    $franchise['firstSeasonId']."', '".
                    $franchise['mostRecentTeamId']."', '".
                    $franchise['teamName']."', '".
                    $franchise['locationName']."', '".
                    $franchise['link'].
                    "');";
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