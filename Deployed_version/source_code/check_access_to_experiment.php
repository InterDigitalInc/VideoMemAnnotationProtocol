<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<?php
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
session_start();

$entered_id = $_POST['password'];

	include('database_connection.php');

	$bdd->quote($entered_id);
    $sql = "SELECT `amt_id` FROM `authorized_clients` WHERE amt_id = '{$entered_id}'";
    $stmt=$bdd->prepare($sql);
	$stmt->execute();
	$exist_or_not = $stmt->fetchAll();
	$stmt->closeCursor();

if (isset($exist_or_not[0]['amt_id']) AND !empty($entered_id)) {
	$_SESSION['amazon_id'] = $entered_id;
	header('Location: welcome_page.php');
} else {
	echo 'Your ID is not correct.';
	echo '<p>To enter a new ID, <a href="access_to_experiment.php">click here</a> to return to the login page.</p>';
}

?>