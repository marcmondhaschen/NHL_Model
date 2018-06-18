<?php
/**
 * This file contains the implementation for the NHL API ReModel's "PeopleController" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 *
 * NOTES ON PEOPLE DATA:
 *  + People data are associated to Teams data by their currentTeam key
 */

namespace NHL_API_Remodel\Controllers;

use PDO;

include 'classes/APICalls.php';

/**
 * The PeopleController Class acts a controller for other classes which provide
 *  + calls to the NHL's open API for player data
 *  + loads player API data to a local MySQL 'persistent storage area' (PSA)
 *  + parses batched player API data from the PSA into required updates for 'production analysis' MySQL tables
 *  + initializes 'people' database for new installations
 * 
 * @package NHL_API_ReModel
 */
class PeopleController extends APICalls
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
    public function getPeopleListAll()
    {
        $result = $this->pdo->query("select * from `nhl_model`.`people` order by `fullName`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sends API call to fetch player ID numbers from all current rosters
     *
     * @access public
     * @return array the array of player ids from all the current teams' rosters
     */
    public function getPeopleInCurrentRosters()
    {
        #TODO build a call for a list of current team IDs

        $rosters_array = $this->APIWrapper("https://statsapi.web.nhl.com/api/v1/teams/?teamId=1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,28,29,30,52,53,54&expand=team.roster", "teams");
        $player_ids   = array();
        foreach($rosters_array as $value) {
            echo $value;
            $roster_array = array($value['roster']['roster']);
            foreach($roster_array as $value) {
                $player_ids = $value['person']['id'];
            }
        }
        return $player_ids;
    }
        /**
     *
     */
    public function updatePeopleList()
    {
        #TODO have this return the people list from the call
        $this->pdo->query("delete from`nhl_model`.`people`;");
        $player_id_array = $this->getPeopleInCurrentRosters();
        $people_count    = count($player_id_array);
        $i = 0;

        while ($i < $people_count) {
            $people_array = APIWrapper("https://statsapi.web.nhl.com/api/v1/people/".$player_id_array[$i], "people");

            $id                 = $people_array[0]['id'];
            $fullName           = str_replace("'", "\'", $people_array[0]['fullName']);
            $link               = $people_array[0]['link'];
            $firstName          = str_replace("'", "\'", $people_array[0]['firstName']);
            $lastName           = str_replace("'", "\'", $people_array[0]['lastName']);
            $primaryNumber      = $people_array[0]['primaryNumber'] ?? 0;
            $birthDate          = $people_array[0]['birthDate'];
            $currentAge         = $people_array[0]['currentAge'];
            $birthCity          = str_replace("'", "\'", $people_array[0]['birthCity']);
            $birthStateProvince = str_replace("'", "\'", $people_array[0]['birthStateProvince'] ?? NULL);
            $birthCountry       = str_replace("'", "\'", $people_array[0]['birthCountry']);
            $nationality        = $people_array[0]['nationality'] ?? NULL;
            $height             = str_replace(array("'", '"'), array("\'", '\"'), $people_array[0]['height']);
            $weight             = $people_array[0]['weight'];
            $active             = $people_array[0]['active'] == 1 ? 1 : 0;
            $alternateCaptain   = $people_array[0]['alternateCaptain'] == 1 ? 1 : 0;
            $captain            = $people_array[0]['captain'] == 1 ? 1 : 0;
            $rookie             = $people_array[0]['rookie'] == 1 ? 1 : 0;
            $shootsCatches      = $people_array[0]['shootsCatches'];
            $rosterStatus       = $people_array[0]['rosterStatus'];
            $currentTeam        = $people_array[0]['currentTeam']['id'];
            $primaryPosition    = $people_array[0]['primaryPosition']['code'];

            if ($people_array[0] != 0) {
                $peopleQuery = "insert into `nhl_model`.`people` (`id`, `fullName`, `link`, `firstName`, `lastName`, `primaryNumber`, ".
                    "`birthDate`, `currentAge`, `birthCity`, `birthStateProvince`, `birthCountry`, `nationality`, `height`, `weight`, ".
                    "`active`, `alternateCaptain`, `captain`, `rookie`, `shootsCatches`, `rosterStatus`, `currentTeam`, `primaryPosition`".
                    ") values (".
                    $id.", '".
                    $fullName."', '".
                    $link."', '".
                    $firstName."', '".
                    $lastName."', ".
                    $primaryNumber.", '".
                    $birthDate."', ".
                    $currentAge.", '".
                    $birthCity."', '".
                    $birthStateProvince."', '".
                    $birthCountry."', '".
                    $nationality."', '".
                    $height."', ".
                    $weight.", ".
                    $active.", ".
                    $alternateCaptain.", ".
                    $captain.", ".
                    $rookie.", '".
                    $shootsCatches."', '".
                    $rosterStatus."', ".
                    $currentTeam.", '".
                    $primaryPosition."');";
                echo $peopleQuery . "<br>";
                //$result      = $this->pdo->query($peopleQuery);
            }

            ++$i;
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