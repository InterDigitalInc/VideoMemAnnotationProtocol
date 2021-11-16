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
$birthday = '\'' . $_POST['day'] . ' ' . $_POST['month'] . ' ' . $_POST['year'] . '\'';

// /*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
// $participant_special_id = mt_rand(1, 2147483647);
$participant_special_id = $_SESSION['amazon_id'];
// $password_day2 = mt_rand(1, 2147483647);
function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}
$password_day2 = rand_string(20);
$password_day2_hashed = password_hash($password_day2, PASSWORD_DEFAULT);

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
include('../database_connection.php');

$query = $bdd->prepare('INSERT INTO survey_table(birthday, country, gender, participant_special_id, password_day2, password_payment ) VALUES(:birthday, :country, :gender, :participant_special_id, :password_day2, :password_payment)');

$query->execute(array(
						'birthday' => $birthday,
						'country' => $_POST['country'],
						'gender' => $_POST['gender'],
						'participant_special_id' => $participant_special_id,
						'password_day2' => $password_day2_hashed,
						'password_payment' => '0',
						 ));

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
$query = $bdd->query("
						UPDATE survey_table
						SET date_time_day1 = TIMESTAMP()
						WHERE participant_special_id = '{$participant_special_id}'
						");

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
$_SESSION['$participant_special_id'] = $participant_special_id;
$_SESSION['$password_day2'] = $password_day2;
$_SESSION['$birthday'] = $birthday;
$_SESSION['$country'] = $_POST['country'];
$_SESSION['$gender'] = $_POST['gender'];

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/
header('Location: video_selection_part1.php');

?>