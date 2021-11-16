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
$_SESSION['amazon_id'] = $_SESSION['amazon_id'];
?>

<!DOCTYPE html>
<html>
   
<head>
	<title>Welcome page</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="style.css" />
</head>

<body>
<!--_________________________________________________________________________________________________________________________________________-->
<h1 class="titlecenter">
	Welcome to our experiment! <br /><br />
</h1>

<p class="txtcenter">
	Is this your first visit?
</p>


<form method="post" action="what_part_of_the_experiment.php">
	<p class="txtcenter">
		<input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" name="part_1" />
		<label for="part_1"><strong>Yes</strong>, I will participate in <strong>part 1</strong> of the experiment</label>
	</p>

	<p class="txtcenter">
		<input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" name="part_2" />
		<label for="part_2"><strong>No</strong>, I will participate in <strong>part 2</strong> of the experiment</label>
	</p>

	<p class="txtcenter">
		<input type="submit" value="Submit" />
	</p>
</form>
<!--_________________________________________________________________________________________________________________________________________-->
</body>
</html>
