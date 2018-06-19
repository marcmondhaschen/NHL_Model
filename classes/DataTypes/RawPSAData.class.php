<?php
/**
 * This file contains the implementation for the NHL API ReModel's "RawPSAData" class.
 *
 * PHP version 7
 *
 * @package NHL_API_ReModel
 * @author Marc Mondhaschen <marcmondhaschen@theubiquitousgooglemailservice.com>
 * @copyright 2018 Marc Mondhaschen
 * @license https://opensource.org/licenses/mit-license.html
 * @link https://github.com/marcmondhaschen/NHL_Model
 */

namespace NHL_API_Remodel\DataTypes;

/**
 * The RawPSAData Class serves as a complex data object for managing NHL API calls and their JSON responses.
 *
 * The RawPSAData Class serves as a complex data object for managing NHL API calls and their JSON responses. It contains
 * call, response, and logging data. It can perform filtering and validation functions on its attributes. RawPSAData
 * objects are mostly created by Collector objects and consumed by
 *
 * @package NHL_API_ReModel
 */
class RawPSAData
{
    protected $callString;
    protected $filter;
    protected $timeStamp;
    protected $response;
    protected $errorMessage;

    /**
     *
     * Returns a new RawPSAData object.
     *
     * @param string $callString
     * @param string $filter
     * @param string $timeStamp
     * @param string $response
     * @param string $errorMessage
     */
    public function __construct($callString = NULL, $filter = NULL, $timeStamp = NULL, $response = NULL, $errorMessage = NULL){
        $this->callString = $callString;
        $this->filter = $filter;
        $this->timeStamp = $timeStamp;
        $this->response = $response;
        $this->errorMessage = $errorMessage;
    }

    /**
     *
     * Returns the RawPSAData object's attributes in a
     *
     * @return array
     */
    public function get() {
        return array("callString"=>     $this->callString,
                     "filter"=>         $this->filter,
                     "timeStamp"=>      $this->timeStamp,
                     "response"=>       $this->response,
                     "errorMessage"=>   $this->errorMessage
                    );
    }
}
