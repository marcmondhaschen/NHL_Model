<?php
/**
 * This file contains the implementation for the NHL API ReModel's "RawPSADataAgent" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Remodel\DataAgents;

use PDO;

/**
 *
 * The RawPSADataAgent class is responsible for passing production data to and from MySQL tables
 *
 * @package NHL_API_ReModel
 */
class RawPSADataAgent extends DataAgent
{
    /**
     * Creates a new RawPSADataAgent object
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Returns all the 'conferences' records in the raw PSA
     */
    public function getConferencesAll()
    {
        $queryString = "select `id`,`name`,`link`,`abbreviation`,`shortName`,`active` from `nhl_model`.`conferences` order by `name`";
        $result = $this->pdo->query($queryString);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}