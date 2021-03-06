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

/**
 *
 * The PSADataAgent class is responsible for passing PSA data to and from MySQL tables
 *
 * @package NHL_API_ReModel
 */
class PSADataAgent extends DataAgent
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }
}