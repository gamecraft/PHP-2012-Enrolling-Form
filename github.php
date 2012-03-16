<?php
header("Content-Type: text/html; charset=utf-8");

define("DIE_MESSAGE", "unicorns.");
require_once "includes.php";

if (!isset($_GET["token"])) {
	die(DIE_MESSAGE);
}

function check_existing_user($token) {
	global $database;
	$sql = "SELECT id,name FROM students WHERE token = ?";
	$res = $database -> query($sql, array($token));
	$row = $res -> fetch(PDO::FETCH_OBJ);

	if ($row === FALSE) {
		return FALSE;
	}

	return $row;
}

if (($user = check_existing_user($_GET["token"])) === FALSE) {
	die(DIE_MESSAGE . " No such user");
}
$successMessage = "";
if (Post_Controller::validate($_POST["github_input"])) {
	$update = "UPDATE students SET github = ? WHERE id = ? LIMIT 1";
	$database -> exec($update, array($_POST["github_input"], (int)$user -> id));
	$successMessage = "Everything's done !";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/main.css" />
		<title> Web Programming with PHP 2012 Github Accounts </title>
	</head>
	<body>
		<div id="container">
			<img class="logo" src="images/php_logo.png" height="67px" weight="132px"/>
			<div id="form-title">
				Web Programming with PHP 2012
			</div>
			<h4><?php echo $successMessage;?></h4>
			<h4>Welcome <?php echo $user -> name;?></h4>
			<form id ="loginform" action="" method="post">
				<table>
					<tr>
						<td><label for="github_input">Github:</label></td>
						<td>
						<input type="text" id="github_input" name="github_input" placeholder="https://github.com/RadoRado/Fmi-Feedback" class="input"/>
						</td>
					</tr>
					<tr>
						<td>
						<input type="submit" class="submit" name="submit" value="Submit" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>