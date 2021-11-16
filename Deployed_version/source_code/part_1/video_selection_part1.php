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

include('../database_connection.php');

/*----------------------------------------------------------------------------------------------------------------------------------------*/
$response = $bdd->query('
                            SELECT urls, nb_annotations_t2
                            FROM video_urls_table
                            ORDER BY nb_annotations_t2, RAND()
                            LIMIT 60
                            ');
    
    $result_fillers_request = $response->fetchAll();
    $fillers_never_repeated = array_column($result_fillers_request, 'urls');
    $response->closeCursor();

/*----------------------------------------------------------------------------------------------------------------------------------------*/
$already_used_urls = "'" . implode("', '", $fillers_never_repeated) . "'";
$response = $bdd->query("
                            SELECT urls, nb_annotations_t1
                            FROM video_urls_table
                            WHERE urls NOT IN ( $already_used_urls )
                            ORDER BY nb_annotations_t1, RAND()
                            LIMIT 60
                            ");
$result_targets_vigi_request = $response->fetchAll();
$targets_and_vigilance = array_column($result_targets_vigi_request, 'urls');
$response->closeCursor();

$targets_first_occurrence = array_slice($targets_and_vigilance,0,40);
$targets_second_occurrence = array_slice($targets_and_vigilance,0,40);
$vigilance_first_occurrence = array_slice($targets_and_vigilance,40,20);
$vigilance_second_occurrence = array_slice($targets_and_vigilance,40,20);

/*----------------------------------------------------------------------------------------------------------------------------------------*/
$prepared_annotated_urls = "'" . implode("', '", $targets_first_occurrence) . "'";
$bdd->exec("
            UPDATE video_urls_table
            SET nb_annotations_T1 = nb_annotations_T1+1
            WHERE urls IN ( $prepared_annotated_urls )
            ");

/*----------------------------------------------------------------------------------------------------------------------------------------*/
	$sequence_nb = rand(1,1000);

	$response = $bdd->query("
							SELECT `sequence_id`, `video_id`, `target1_or_filler0`, `firstoccurrence1_or_secondoccurrence2`, `video_position`
							FROM `positions_orders_table`
							WHERE sequence_id = '{$sequence_nb}'
							ORDER BY `video_id` ASC
							");

	$positions_sequence = $response->fetchAll();

	$response->closeCursor();
	
/*----------------------------------------------------------------------------------------------------------------------------------------*/
	$typed_urls = array_merge($vigilance_first_occurrence, $vigilance_second_occurrence, $targets_first_occurrence, $targets_second_occurrence, $fillers_never_repeated);

	$video_positions = array_column($positions_sequence, 'video_position');//array_column returns the values of one column of an array
	
		$length = count($video_positions);
		for ($i = 0; $i < $length; $i++) {
			$video_positions[$i] = intval($video_positions[$i]);
		}

	$video_positions_clone = $video_positions;


	array_multisort($video_positions, $typed_urls);
	$definitive_urls_order = $typed_urls;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
	array_multisort($video_positions_clone, $positions_sequence);

/*----------------------------------------------------------------------------------------------------------------------------------------*/
	$_SESSION['$definitive_urls_order'] = $definitive_urls_order;
	$_SESSION['$tags_right_order'] = $positions_sequence;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
header('Location: instructions.php');

?>
