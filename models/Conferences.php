<?php
/**
 * This file contains the implementation for the NHL API ReModel's "Conferences" class.
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

class Conferences extends APICalls
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getConferenceList()
    {
        $result = $this->pdo->query("select `id`,`name`,`link`,`abbreviation`,`shortName`,`active` from `nhl_model`.`conferences` order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function APIWrapper($callString, $arrayElement = NULL)
    {
        parent::APIWrapper($callString, $arrayElement);
    }
}