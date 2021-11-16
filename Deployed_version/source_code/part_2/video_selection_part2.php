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

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
include('../database_connection.php');

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
$bdd->exec("
			UPDATE survey_table
			SET password_day2 = '!!!333hfizehf4598464786izhofz333!!!'
			WHERE participant_special_id = '{$_SESSION['$participant_special_id']}'
			");

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
//$password_AMT = rand(1, 2147483647);
function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}
// $password_AMT = rand_string(20);
$password_AMT='BrpSdiy2nuJ1efOZ0000';
$password_AMT_hashed = password_hash($password_AMT, PASSWORD_DEFAULT);

$bdd->exec("
			UPDATE survey_table
			SET password_payment = '{$password_AMT_hashed}'
			WHERE participant_special_id = '{$_SESSION['$participant_special_id']}'
			");

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
	$response = $bdd->query("
							SELECT subject, birthday, country, gender, sequence_id, target1_or_filler0, firstoccurrence1_or_secondoccurrence2, url_name 
							FROM results_day1_on_table
							WHERE subject = '{$_SESSION['$participant_special_id']}'
							AND target1_or_filler0 = 0 
							");

	$fillers_saw_once_day1 = $response->fetchAll();
	
	$alea_target_choice = rand(1, 19);
	$day2_targets = array_slice($fillers_saw_once_day1, $alea_target_choice, 40);

	$response->closeCursor();

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
$day2_targets_urls = array_column($day2_targets, 'url_name');

$prepared_annotated_urls = "'" . implode("', '", $day2_targets_urls) . "'";

$bdd->exec("
			UPDATE video_urls_table
			SET nb_annotations_T2 = nb_annotations_T2+1
			WHERE urls IN ( $prepared_annotated_urls )
			");

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
	$response = $bdd->query("
							SELECT DISTINCT(url_name)
							FROM results_day1_on_table
							WHERE subject = '{$_SESSION['$participant_special_id']}'
							AND url_name IS NOT NULL
							");

	$already_used_urls = $response->fetchAll();

	$response->closeCursor();

	$used_urls = array_column($already_used_urls, 'url_name');

	$prepared_used_urls = "'" . implode("', '", $used_urls) . "'";

	$response = $bdd->query("
								SELECT urls
								FROM video_urls_table
								WHERE urls NOT IN ( $prepared_used_urls )
								ORDER BY RAND()
								LIMIT 80
							");

	$day2_fillers = $response->fetchAll();

	$response->closeCursor();

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
	$day2_urls_targets = array_column($day2_targets, 'url_name');
	$day2_urls_fillers = array_column($day2_fillers, 'urls');
		
	$all_day2_urls = array_merge($day2_urls_targets, $day2_urls_fillers);

	$video_id =  range(1,120);
	$target1_or_filler0 = array_merge(array_fill(0,40,1), array_fill(0, 80, 0));
	$firstoccurrence1_or_secondoccurrence2 = array_fill(0, 120, 1);
	
	$video_positions = array();
	for($i = 1; $i <= 120;) {
		unset($rand);
	    $rand = rand(1, 120);
    	if(!in_array($rand, $video_positions)) {
    		$video_positions[] = $rand;
        	$i++;
        }
    }

	$video_positions_clone1 = $video_positions;
	$video_positions_clone2 = $video_positions;
	$video_positions_clone3 = $video_positions;

	array_multisort($video_positions, $all_day2_urls);
	array_multisort($video_positions_clone1, $video_id);
	array_multisort($video_positions_clone2, $target1_or_filler0);
	array_multisort($video_positions_clone3, $firstoccurrence1_or_secondoccurrence2);

/*----------------------------------------------------------------------------------------------------------------------------------------*/
	$_SESSION['$definitive_urls_order'] = $all_day2_urls;
	$_SESSION['$video_positions'] = $video_positions;
	$_SESSION['$video_id'] = $video_id;
	$_SESSION['$target1_or_filler0'] = $target1_or_filler0;
	$_SESSION['$firstoccurrence1_or_secondoccurrence2'] = $firstoccurrence1_or_secondoccurrence2;
	$_SESSION['$fillers_saw_once_day1'] = $fillers_saw_once_day1;
	$_SESSION['$password_AMT'] = $password_AMT;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
header('Location: VM_experiment_part_2.php');

?>