<?php
/**
 * This file contains the implementation for the NHL API ReModel's "ConferenceController" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Remodel\Models;

use \NHL_API_Remodel\API_Calls\GuzzleAPICall as GuzzleAPICall;

/**
 * The ConferenceCollector Class collects JSON NHL conference API data via GuzzleAPICall object and feeds
 * these results to a
 *
 * @package NHL_API_ReModel
 */
class ConferenceCollector extends APICalls
{
    protected $GuzzleAPICall;
    
    public function __construct(){
        $this->GuzzleAPICall = new GuzzleAPICall;
    }
    public function fetchAllConferences()
    {
        return 1;
    }
}

