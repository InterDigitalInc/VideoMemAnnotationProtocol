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
	<title>Page</title>
	<meta charset="utf-8" />
</head>


<body>
<!--_________________________________________________________________________________________________________________________________________-->
<p>
	You are at the second part of your experiment.<br />
	Please log in with the password gave to you yesterday to log in.
</p>

<form method="post" action="connection_part2.php">
	<p>
		<input type="text" name="password">
		<input type="submit" value="Valider" />
    </p>
</form>

<!--_________________________________________________________________________________________________________________________________________-->
</body>
</html>