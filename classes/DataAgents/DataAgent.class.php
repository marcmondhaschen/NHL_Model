<?php
/**
 * This file contains the implementation for the NHL API ReModel's "DataAgent" class.
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

require_once 'vendor/autoload.php';

/**
 *
 * The DataAgent class is responsible for passing data to and from MySQL tables
 *
 * @package NHL_API_ReModel
 */
class DataAgent
{
    protected $pdo;

    /**
     * Builds a new DataAgent object
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}