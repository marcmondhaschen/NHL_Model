<?php
/* 
    author: Marc Mondhaschen
    date: 2018/06/05

    purpose: this project captures NHL team, player, and game
    data from the NHL's API to a local MySQL database  
*/

include 'config/db.inc.php';
include 'models/People.php';
use NHL_API_Model\Models\People as People;

$people = new People($pdo);
$people->updatePeopleList();
//$teamsList = $teams->getTeamListAll();

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
        <?php  ?>                
    </div>
  <script src="js/custom.js"></script>
</body>
</html>
