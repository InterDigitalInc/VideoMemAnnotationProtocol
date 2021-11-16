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
$password_day2 = $_POST['password'];
$participant_special_id = $_SESSION['amazon_id'];

/*---------------------------------------------------------------------------------------------------------------------------------------------------- */
if ($password_day2 == NULL) {
	echo '<p>You have to enter an correct password to access the second part of the experiment.</p>';
	echo '<p>To enter a new password, <a href="welcome_page_part_2.php">click here</a> to return to the login page.</p>';
} else {
	include('../database_connection.php');
	//Get hashed password
	$response = $bdd->query("SELECT `password_day2` FROM `survey_table` WHERE participant_special_id = '{$participant_special_id}' ORDER BY id_participant DESC LIMIT 1");
	$resp_get = $response->fetchAll();
	$hashed_password = $resp_get[0][0];
	$response->closeCursor();

	if(password_verify($password_day2, $hashed_password)) {
		$response = $bdd->query("
								SELECT date_time_day1
								FROM survey_table
								WHERE participant_special_id = '{$participant_special_id}'
								");
		$dates = $response->fetchAll();
		$date1 = strtotime($dates[0]['date_time_day1']);
		$response->closeCursor();

		//Date and time day 2
		$bdd->quote($participant_special_id);
		$query = $bdd->prepare('INSERT INTO date_time_day2_table(participant_special_id) VALUES(:participant_special_id)');
		$query->execute(array('participant_special_id' => $participant_special_id));

		$resp = $bdd->query("
								SELECT date_time_day2
								FROM date_time_day2_table
								WHERE participant_special_id = '{$participant_special_id}'
								ORDER BY id_table DESC
								LIMIT 1
								");
		$date_2 = $resp->fetchAll();
		$date2 = strtotime($date_2[0]['date_time_day2']);
		$resp->closeCursor();

		$elapsed_time = $date2 - $date1;
		$ok_time_start = 86400;
		$ok_time_end = 262800;

		if ($elapsed_time < $ok_time_start) {
			echo 'It is too early for the second part! Please come back between 24 and 72 hours after part 1.';
		} else if ($elapsed_time > $ok_time_end){
			echo 'It\'s too late. We can\'t accept you for the second part of the experiment.';
		} else {
			$_SESSION['$participant_special_id'] = $participant_special_id;
			header('Location: video_selection_part2.php');
		}

	} else {
		echo 'The password is not correct.';
		echo '<p>To enter a new password, <a href="welcome_page_part_2.php">click here</a> to return to the login page.</p>';
	}
}
?>