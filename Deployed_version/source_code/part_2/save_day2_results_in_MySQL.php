<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<?php
$trials = json_decode($_POST['json']);
include('../database_connection.php');

for ($i=0; $i < count($trials) ; $i++) {
	$to_insert = (array)($trials[$i]);
    $keys = array_keys($to_insert);
	$bdd->quote($to_insert);
	$bdd->quote($table);

	$stmt = $bdd->prepare('INSERT INTO results_day2_on_table (rt, key_press, trial_type, trial_index, time_elapsed, internal_node_id, subject, birthday, country, gender, screen_width, screen_height, stimulus, video_id, target1_or_filler0, firstoccurrence1_or_secondoccurrence2, video_position, url_name, correct) VALUES (:rt, :key_press, :trial_type, :trial_index, :time_elapsed, :internal_node_id, :subject, :birthday, :country, :gender, :screen_width, :screen_height, :stimulus, :video_id, :target1_or_filler0, :firstoccurrence1_or_secondoccurrence2, :video_position, :url_name, :correct)');

	$stmt->bindParam(':rt', $to_insert[rt]);
	$stmt->bindParam(':key_press', $to_insert[key_press]);
	$stmt->bindParam(':trial_type', $to_insert[trial_type]);
	$stmt->bindParam(':trial_index', $to_insert[trial_index]);
	$stmt->bindParam(':time_elapsed', $to_insert[time_elapsed]);
	$stmt->bindParam(':internal_node_id', $to_insert[internal_node_id]);
	$stmt->bindParam(':subject', $to_insert[subject]);
	$stmt->bindParam(':birthday', $to_insert[birthday]);
	$stmt->bindParam(':country', $to_insert[country]);
	$stmt->bindParam(':gender', $to_insert[gender]);
	$stmt->bindParam(':screen_width', $to_insert[screen_width]);
	$stmt->bindParam(':screen_height', $to_insert[screen_height]);
	$stmt->bindParam(':stimulus', $to_insert[stimulus]);
	$stmt->bindParam(':video_id', $to_insert[video_id]);
	$stmt->bindParam(':target1_or_filler0', $to_insert[target1_or_filler0]);
	$stmt->bindParam(':firstoccurrence1_or_secondoccurrence2', $to_insert[firstoccurrence1_or_secondoccurrence2]);
	$stmt->bindParam(':video_position', $to_insert[video_position]);
	$stmt->bindParam(':url_name', $to_insert[url_name]);
	$stmt->bindParam(':correct', $to_insert[correct]);

	$stmt->execute();
}

?>

