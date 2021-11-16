<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<?php
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
$_SESSION['amazon_id'] = $_SESSION['amazon_id'];
?>

<!DOCTYPE html>
<html>
   
<head>
	<title>Welcome page part 1</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../style.css" />
</head>

<body>
<!--_____________________________________________________________________________________________________________________________________________-->
<h1 class="titlecenter">
	Part 1 of the experiment.
</h1>

<div class="txtcenter">
	As you have been informed by the presentation page on the Mechanical Turk's website, the experiment takes place in two different steps:<br />
</div>

<ul class="txtcenter">
	<li><strong>Today</strong>, we will test your memory for a set of videos you'll discover during the task; </li>
	<br />
	<li><strong>In 24 to 72 hours</strong>, we will test you memory again for some of these videos.</li>
</ul>

<div class="txtcenter">
	Be aware that the initialization process of the experiment can last from seconds to minutes depending on the speed of your internet connection.<br />
</div>


<form method="post" action="demographics.php">
	<p class="txtcenter">
		<input type="submit" value="Next" />
    </p>
</form>

<!--_________________________________________________________________________________________________________________________________________-->
</body>
</html>