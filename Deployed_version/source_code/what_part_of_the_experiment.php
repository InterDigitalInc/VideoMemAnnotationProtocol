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

if (isset($_POST['part_1']) and !isset($_POST['part_2']))
	{
		header('Location: part_1/welcome_page_part_1.php');
	}

else if (!isset($_POST['part_1']) and isset($_POST['part_2']))
	{
		header('Location: part_2/welcome_page_part_2.php');
	}

else if (!isset($_POST['part_1']) and !isset($_POST['part_2']))
	{
		header('Location: index.php');
	}

else
	{
		header('Location: index.php');
	}
?>
