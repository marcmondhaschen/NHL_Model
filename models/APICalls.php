<?php
namespace NHL_API_Model\Models;

class APICalls {
    
    function APIWrapper($callString, $arrayElement = NULL) {
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
            echo "Error calling NHL API: " . $e->getMessage() . "\n";
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

