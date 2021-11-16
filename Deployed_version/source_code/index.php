<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->

<?php
/*---------------------------------------------------------------------------------------------------*/
include('database_connection.php');
$bdd->quote($test);
$stmt = $bdd->prepare('INSERT INTO authorized_clients (amt_id) VALUES (:amt_id)');
$stmt->bindParam(':amt_id', $test = $_GET['MID']);
$stmt->execute();

// setup session enviroment
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');

header('Location: access_to_experiment.php');

/*---------------------------------------------------------------------------------------------------*/

?>