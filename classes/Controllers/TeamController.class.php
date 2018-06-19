<?php
/**
 * This file contains the implementation for the NHL API ReModel's "TeamController" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 *
 * NOTES ON TEAMS DATA:
 *  + Teams are associated to their franchises by the franchiseID key
 *  + Teams are associated to their division by their division key
 *  + Teams are associated to their conference by their conference key
 *  + Team numbers are not issued or logged sequentially, and are not contiguous
 *  + Many teams, including exhibition & All Star Teams, are logged as 'active'
 *  + Regular league teams are distinguished by their non-null 'conferece' & 'division' assignments
 *  + The Penguins don't have a firstYearOfPlay entry as of this writing. Correct first year of play for the Penguins
 *    is 1967
 *  + As of 6/6/18, the highest team id located is 101 (we polled to 1000)
 */

namespace NHL_API_Remodel\Models;

use PDO;

/**
 * The TeamController Class acts a controller for other classes which provide
 *  + calls to the NHL's open API for teams data
 *  + loads team API data to a local MySQL 'persistent storage area' (PSA)
 *  + parses batched team API data from the PSA into required updates for 'production analysis' MySQL tables
 *  + initializes 'teams' database for new installations
 * 
 * @package NHL_API_ReModel
 */
class TeamController extends APICalls
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
    public function getTeamListAll()
    {
        $result = $this->pdo->query("select * from `nhl_model`.`teams` order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @return type
     */
    public function getTeamListActive()
    {
        $result = $this->pdo->query("select * from `nhl_model`.`teams` where active = true order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     */
    public function updateTeamList()
    {
        $maxTeamFound = 105;
        $i            = 1;

        $this->pdo->query("delete from`nhl_model`.`teams`;");
        $this->pdo->query("delete from`nhl_model`.`venues`;");
        $this->pdo->query("delete from`nhl_model`.`timezones`;");

        while ($i <= $maxTeamFound) {
            $team_array = $this->APIWrapper("https://statsapi.web.nhl.com/api/v1/teams/".$i, "teams");

            $id              = $team_array[0]['id'];
            $name            = $team_array[0]['name'];
            $link            = $team_array[0]['link'];
            $venue           = $team_array[0]['venue']['name'] ?? NULL;
            $venueLink       = $team_array[0]['venue']['link'] ?? NULL;
            $city            = $team_array[0]['venue']['city'] ?? NULL;
            $timezone        = $team_array[0]['venue']['timeZone']['id'] ?? NULL;
            $offset          = $team_array[0]['venue']['timeZone']['offset'] ?? NULL;
            $tz              = $team_array[0]['venue']['timeZone']['tz'] ?? NULL;
            $abbreviation    = $team_array[0]['abbreviation'];
            $teamName        = $team_array[0]['teamName'];
            $locationName    = $team_array[0]['locationName'];
            $firstYearOfPlay = $team_array[0]['firstYearOfPlay'] ?? 0;
            $division        = $team_array[0]['division']['id'] ?? 0;
            $conference      = $team_array[0]['conference']['id'] ?? 0;
            $shortName       = $team_array[0]['shortName'] ?? NULL;
            $officialSiteUrl = $team_array[0]['officialSiteUrl'] ?? NULL;
            $franchiseId     = $team_array[0]['franchiseId'] ?? 0;
            $active          = $team_array[0]['active'] == 1 ? 1 : 0;

            if ($team_array[0] != 0) {
                $teamQuery = "insert into `nhl_model`.`teams` (`id`,`name`,`link`,`venue`,`abbreviation`,`teamName`,".
                    "`locationName`,`firstYearOfPlay`,`division`,`conference`,`shortName`,`officialSiteUrl`,".
                    "`franchiseId`,`active`) values (".
                    $id.", '".
                    $name."', '".
                    $link."', '".
                    $venue."', '".
                    $abbreviation."', '".
                    $teamName."', '".
                    $locationName."', '".
                    $firstYearOfPlay."', ".
                    $division.", ".
                    $conference.", '".
                    $shortName."', '".
                    $officialSiteUrl."', ".
                    $franchiseId.", '".
                    $active."');";
                $result    = $this->pdo->query($teamQuery);
            }

            if ($venue) {
                $venueQuery = "insert into `nhl_model`.`venues` (`name`,`link`,`city`,`timezone`) values ('".
                    $venue."', '".
                    $venueLink."', '".
                    $city."', '".
                    $timezone."');";
                $result     = $this->pdo->query($venueQuery);
            }

            if ($timezone) {
                $timeZoneQuery = "insert into `nhl_model`.`timezones` (`id`,`offset`,`tz`) values ('".
                    $timezone."', '".
                    $offset."', '".
                    $tz."');";
                $result        = $this->pdo->query($timeZoneQuery);
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