<?php
/**
 * This file contains the implementation for the NHL API ReModel's "Collector" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Remodel\Collectors;

use GuzzleHttp;

require_once 'vendor/autoload.php';

/**
 * The Collector Class collects NHL data as raw strings from Guzzle API calls and returns the fetched data along with
 * logging information
 *
 * @package NHL_API_ReModel
 */
class Collector
{
    #TODO abstract $uriPrefix into a constant in this namespace
    protected $client;
    public $uriPrefix = 'https://statsapi.web.nhl.com/';
    
    /**
     * builds a new Collector object
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();
    }

    /**
     * sends a Guzzle API call and records the response as a string
     *
     * @param string $callString    the URL string to be used for an API call
     * @param string $filter        assuming relevant data is stored in the second layer of a JSON array, it can be
     *                              within an fetched from inside an element of $arrayElement's name
     *                              ex: APIWrapper("https://statsapi.web.nhl.com/api/v1/teams/", "teams");
     *                              returns a list of all teams in the 'teams' element of the JSON returned by the URI
     *                              https://statsapi.web.nhl.com/api/v1/teams/
     * @return array                a five element array 
     *                                  + $callString   the URI call string
     *                                  + $filter       any filtering argument added, used for parsing JSON later
     *                                  + $timeStamp    the current system time
     *                                  + (string) $res->getBody() the JSON returned by the Guzzle call to $callString
     *                                  + $errorMessage error messages
     */
    public function call($callString, $filter = NULL)
    {
        $res          = $this->client->request('GET', $callString);
        $errorMessage = ''; #TODO catch error messages for returned tuple
        $timeStamp    = date('Y-m-d H:i:s');
        return array($callString, $filter, $timeStamp, (string) $res->getBody(), $errorMessage);
    }
}