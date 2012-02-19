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
	<title> PHP 2012 </title>
	<body>
		<div id="container">
			<form action="" method="post">
				<h3>Enrolling for Web Programming with PHP 2012</h3>
				<h4><?php echo $error_msg;?></h4>
				<h4><?php echo $success_msg;?></h4>
				<table>
					<tr>
						<td><label>Name:</label></td>
						<td>
						<input type="text" name="name_input" placeholder="Your name"/>
						</td>
					</tr>
					<tr>
						<td><label>Email:</label></td>
						<td>
						<input type="email" name="email_input" placeholder="Your email"/>
						</td>
					</tr>
					<tr>
						<td><label>Faculty Number:</label></td>
						<td>
						<input type="text" name="number_input" placeholder="Your faculty number"/>
						</td>
					</tr>
					<tr>
						<!-- CAPTCHA PLACEHOLDER -->
					</tr>
					<tr>
						<td>
						<input type="submit" name="submit" value="Enroll" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>