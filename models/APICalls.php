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

namespace NHL_API_Model\Models;

class APICalls
{
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

        if (isset($arrayElement)) {
            return $result_array[$arrayElement];
        } else {
            return $result_array;
        }
    }
}