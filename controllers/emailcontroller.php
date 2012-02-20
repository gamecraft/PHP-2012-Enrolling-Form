<?php

class Email_Controller {
	/**
	 Validate an email address.
	 Provide email address (raw input)
	 Returns true if the email address has the email
	 address format and the domain exists.
	 Source: http://www.linuxjournal.com/article/9585?page=0,3
	 */
	public static function validate($email) {
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex + 1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			} else if ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			} else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			} else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			} else if (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}

	public static function emailEnrollmentInformation($to) {
		$to = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $to), ENT_COMPAT, 'UTF-8'));

		$subject = "Записан си в курса Web Програмиране с PHP 2012";

		$message = "Сайтът за курса е : http://php.dev.bg/ \n";
		$message .= "Twitter акаунта за курса е : @phpfmi \n";
		$message .= "Ранглистата се намира на следния адрес : http://game-craft.com/php2012/leaderboard/";

		$headers = "From: radoslavjg@fmi.uni-sofia.bg" . "\r\n" . "Reply-To: radoslavjg@fmi.uni-sofia.bg" . "\r\n" . "X-Mailer: PHP/" . phpversion();

		mail($to, $subject, $message, $headers);
	}

}
