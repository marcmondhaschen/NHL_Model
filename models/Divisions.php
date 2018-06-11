<?php

namespace NHL_API_Model\Models;

use PDO;

class Divisions extends APICalls
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDivisionList()
    {
        $result = $this->pdo->query("select `id`, `name`, `link`, `abbreviation`, `conference`, `active` from `nhl_model`.`divisions` order by `name`;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    #TODO: build a function that grabs inactive as well as active divisions

    public function updateDivisionList()
    {
        #TODO: update this function to test for new division updates, without rewriting the entire list
        $divisions_array = parent::APIWrapper("https://statsapi.web.nhl.com/api/v1/divisions",
                "divisions");
        $division_count  = count($divisions_array);

        $result = $this->pdo->query("delete from`nhl_model`.`divisions`;");

        for ($i = 0; $i < $division_count; ++$i) {
            if (is_numeric($divisions_array[$i]['id']) && is_string($divisions_array[$i]['name'])) {
                $query = "insert into `nhl_model`.`divisions` (`id`,`name`,`link`,`abbreviation`,`conference`,`active`) values (".
                    $divisions_array[$i]['id'].", '".
                    $divisions_array[$i]['name']."', '".
                    $divisions_array[$i]['link']."', '".
                    $divisions_array[$i]['abbreviation']."', ".
                    $divisions_array[$i]['conference']['id'].", ".
                    $divisions_array[$i]['active'].
                    ");";

                $result = $this->pdo->query($query);
            } else {
                echo "Error: Some of the data fetched from the NHL API appears to be corrupted.";
            }
        }
    }
}