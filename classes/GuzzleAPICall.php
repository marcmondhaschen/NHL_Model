<?php
/**
 * This file contains the implementation for the NHL API ReModel's "GuzzleAPICall" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Remodel\API_Calls;

use GuzzleHttp;

require_once 'vendor/autoload.php';

/**
 * The GuzzleAPICall Class makes guzzle requests to an open NHL API and returns the results as JSON strings
 *
 * @package NHL_API_ReModel
 */
class GuzzleAPICall
{
    protected $client;

    /**
     * builds a new GuzzleAPICall object
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
     * @return array                a two element array - first element is the string returned by the URI, the second
     *                              is any filtering argument added by the user
     */
    public function call($callString, $filter = NULL)
    {
        $res = $this->client->request('GET', $callString);
        return array((string)$res->getBody(),$filter);
    }
}
