<?php

class Captcha_Controller {
	public static function validate($captcha) {
		$score = $captcha -> scoreResult();
		if ($score) {
			echo "Successful";
			echo $captcha -> recordConversion();
		} else {
			echo "Not...";
		}

	}

}
