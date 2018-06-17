<?php
/**
 * This file is a test page for the NHL API Remodel Project
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

include 'config/db.inc.php';
include 'classes/People/PeopleController.php';

use NHL_API_Remodel\Models\PeopleController as PeopleController;

$people    = new PeopleController($pdo);
$people->updatePeopleList();
$peopleList = $people->getPeopleListAll();
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>NHL Model</title>
        <meta name="description" content="NHL Model">
        <link rel="stylesheet" href="css/custom.css">
    </head>

    <body>
        <div>
            <?php echo "<pre>";print_r($peopleList);echo "</pre>"; ?>
        </div>
        <script src="js/custom.js"></script>
    </body>
</html>
