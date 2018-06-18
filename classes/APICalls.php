<?php
/**
 * This file contains the implementation for the NHL API ReModel's "APICalls" class.
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

/**
 * The APICalls Class makes curl requests to an open API and returns the results as associative arrays
 *
 * I hand built a bunch of curl stuff and then decided to just make it easy on myself and use Guzzle
 * All of this stuff is getting deprecated. :)
 *
 * @package NHL_API_ReModel
 */
class APICalls
{
    /**
     *
     * @param type $callString   the URL string to be used for an API call
     * @param type $arrayElement assuming relevant data is stored in the second layer of a JSON array, it can be
     *                           within an fetched from inside an element of $arrayElement's name
     *                           ex: APIWrapper("https://statsapi.web.nhl.com/api/v1/teams/", "teams"); returns a list
     *                           of all teams in the 'teams' element of the JSON returned by
     *                           https://statsapi.web.nhl.com/api/v1/teams/
     * @return type
     * @throws Exception
     */
    public function APIWrapper($callString, $arrayElement = NULL)
    {
        $cr = curl_init();
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cr, CURLOPT_URL, $callString);

        try {
            $result_string = curl_exec($cr);
            if (!$result_string) {
                throw new Exception('API call returned no results.');
            } elseif (strpos($result_string, '"Object not found"')) {
                return [0];
            }
        } catch (Exception $e) {
            echo "Error calling NHL API: ".$e->getMessage()."\n";
        }

        curl_close($cr);
        $result_array = json_decode($result_string, true);

        if (isset($arrayElement) && is_array($result_array)) {
            //var_dump($result_array[$arrayElement]);
            return $result_array[$arrayElement];
        } else {
            return $result_array;
        }
    }
}