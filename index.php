<?php
require_once "includes.php";

$error_msg = "";
$success_msg = "";
$captchaHtml = $areYouHuman -> getPublisherHTML();

if ($_POST['submit']) {
	if (Post_Controller::validate($_POST['name_input']) && Post_Controller::validate($_POST['email_input']) && Post_Controller::validate($_POST['number_input'])) {
		//captcha validation
		Captcha_Controller::validate($areYouHuman);

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
						<td><label for="name_input">Name:</label></td>
						<td>
						<input type="text" id="name_input" name="name_input" placeholder="Your name" class="input"/>
						</td>
					</tr>
					<tr>
						<td><label for="email_input">Email:</label></td>
						<td>
						<input type="email" id="email_input" class="input" name="email_input" placeholder="Your email"/>
						</td>
					</tr>
					<tr>
						<td><label for="number_input">Faculty Number:</label></td>
						<td>
						<input type="text" id="number_input" class="input" name="number_input" placeholder="Your faculty number"/>
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