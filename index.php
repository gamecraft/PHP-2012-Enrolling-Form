<?php
require_once "includes.php";

$error_msg = "";
$success_msg = "";

if ($_POST['submit']) {
	if (Post_Controller::validate($_POST['name_input']) && Post_Controller::validate($_POST['email_input']) && Post_Controller::validate($_POST['number_input'])) {
		//captcha validation

		if (Email_Controller::validate($_POST['email_input'])) {
			$sql = "INSERT INTO students(name, email, faculty_number) VALUES (? , ? , ?)";
			try {
				$database -> exec($sql, array($_POST['name_input'], $_POST['email_input'], $_POST['number_input']));
			} catch (Exception $e) {
				$error_msg = "Existing student";
			}

		} else {
			$error_msg = 'Incorrect email';
		}
	} else {
		$error_msg = "Please fill all the inputs.";
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/main.css" />
		<title> Web Programming with PHP 2012 Enrolling </title>
	</head>
	<body>
		<div id="container">
			<img class="logo" src="images/php_logo.png" height="67px" weight="132px"/>
			<div id="form-title">Web Programming with PHP 2012</div>
			<form id ="loginform" action="" method="post">
				<h4><?php echo $error_msg;?></h4>
				<h4><?php echo $success_msg;?></h4>
				<table>
					<tr>
						<td><label>Name:</label></td>
						<td>
						<input type="text" class="input" name="name_input" />
						</td>
					</tr>
					<tr>
						<td><label>Email:</label></td>
						<td>
						<input type="email" class="input" name="email_input" />
						</td>
					</tr>
					<tr>
						<td><label>Faculty Number:</label></td>
						<td>
						<input type="text" class="input" name="number_input" />
						</td>
					</tr>
					<tr>
						<!-- CAPTCHA PLACEHOLDER -->
					</tr>
					<tr>
						<td></td>
						<td>
						<input type="submit" class="submit" name="submit" value="Submit" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>