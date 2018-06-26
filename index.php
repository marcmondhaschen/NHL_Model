<?php
/**
 * This file is a test page for the NHL API Remodel Project
 *
 * Future versions of this page will invite users to update and peruse a local copy of the NHL's open API database
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @date: 2018/06/15
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 *
 * NOTES ON PEOPLE DATA:
 *  + People data are associated to Teams data by their currentTeam key
 */



///*test collector class*/
//require "vendor/autoload.php";
//use NHL_API_Remodel\Collectors\Collector;
//$caller = new Collector();
//$callString = 'https://statsapi.web.nhl.com/api/v1/teams';
//$catchArray = $caller->call($callString,'teams');
//echo "<pre>";print_r($catchArray);echo "</pre>";

///*test conferencecollector class */
//require "vendor/autoload.php";
//use NHL_API_Remodel\Collectors\ConferenceCollector;
//$caller = new ConferenceCollector();
//$catchArray = $caller->fetchCurrentConferences();
//echo "<pre>";print_r($catchArray);echo "</pre>";

///*test RawPSADataAgent class*/
require "vendor/autoload.php";
require_once 'config/db.inc.php';

use NHL_API_Remodel\Collectors\ConferenceCollector;
use NHL_API_Remodel\DataAgents\RawPSADataAgent;
$collector = new ConferenceCollector();
$RawPSAData = $collector->fetchCurrentConferences();
$RawPSADataAgent = new RawPSADataAgent($rawPSAPDO);