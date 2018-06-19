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

namespace NHL_API_Remodel\Collectors;

/**
 * The ConferenceCollector Class fetches NHL conference data using canned Guzzle API requests.
 *
 * The ConferenceCollector Class fetches NHL conference data using its parent's 'call' function and preconstructed
 * queries. These queries return RawPSAData objects or arrays of RawPSAData objects, intended for ingestion by 
 *
 * @package NHL_API_ReModel
 */
class ConferenceCollector extends Collector
{
    private $filter;
    private $uriSuffix;

    /**
     * Builds a new ConferenceCollector object.
     */
    public function __construct()
    {
        #TODO abstract $classUriSuffix into a constant in this namespace
        parent::__construct();
        $this->uriSuffix = 'api/v1/conferences/';
        $this->filter    = 'conferences';
    }

    /**
     * Fetches a list of all conferences, including inactive conferences.
     * 
     * Fetches a list of all conferences, including inactive conferences, starting at 1 and incrementing by 1 until 
     * an error is encountered. Returns an array of RawPSAData objects.
     *
     * @return array
     */
    public function fetchAllConferences()
    {
        #TODO convert return value to RawPSA data object
        #TODO catch error messages
        #TODO fix stop in while on error message from guzzle
        $returnValues = array();
        $i            = 1;
        while ($i < 7) {
            $callString     = $this->uriPrefix.$this->uriSuffix.$i;
            $returnValues[] = $this->call($callString, $this->filter);
            ++$i;
        }
        return $returnValues;
    }

    /**
     * Fetches a list of active conferences.
     *
     * Returns an array of RawPSA data objects.
     *
     * @return array
     */
    public function fetchCurrentConferences()
    {
        #TODO convert return value to RawPSA data object
        #TODO catch error messages
        $callString = $this->uriPrefix.$this->uriSuffix;
        return $this->call($callString, $this->filter);
    }

    /**
     * Fetches a list of all the conferences, starting at conference #1 and running unit an error message is encountered
     *
     * @return array
     */
    public function fetchSpecificConference(int $i)
    {
        #TODO convert return value to RawPSA data object
        #TODO catch error messages
        $callString = $this->uriPrefix.$this->classUriSuffix.$i;
        return $this->call($callString, $this->filter);
    }

    /**
     * Sends a Guzzle API call and records the response as a string
     *
     * inherited from Collector class
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
        return parent::call($callString, $filter);
    }
}