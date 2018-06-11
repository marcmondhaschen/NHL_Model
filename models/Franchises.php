<?php

namespace NHL_API_Model\Models;

use PDO;

class Franchises extends APICalls
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFranchiseList()
    {
        $result = $this->pdo->query("select `franchiseId`,`firstSeasonId`,`mostRecentTeamId`,`teamName`,`locationName`,`link` from `nhl_model`.`franchises` order by `teamName`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateFranchiseList()
    {
        $franchises_array = parent::APIWrapper("https://statsapi.web.nhl.com/api/v1/franchises",
                "franchises");
        $franchise_count  = count($franchises_array);

        $result = $this->pdo->query("delete from`nhl_model`.`franchises`;");

        for ($i = 0; $i < $franchise_count; ++$i) {
            if (is_numeric($franchises_array[$i]['franchiseId']) && is_string($franchises_array[$i]['teamName'])) {
                $query  = "insert into `nhl_model`.`franchises` (`franchiseId`,`firstSeasonId`,`mostRecentTeamId`,`teamName`,`locationName`,`link`) values (".
                    $franchises_array[$i]['franchiseId'].", '".
                    $franchises_array[$i]['firstSeasonId']."', '".
                    $franchises_array[$i]['mostRecentTeamId']."', '".
                    $franchises_array[$i]['teamName']."', '".
                    $franchises_array[$i]['locationName']."', '".
                    $franchises_array[$i]['link'].
                    "');";
                $result = $this->pdo->query($query);
            } else {
                echo "Error: While updating the franchises table, some of the data fetched from the NHL API appears to be corrupted.";
            }
        }
    }
}