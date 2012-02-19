<?php

class Post_Controller {

	public static function validate($input) {
		return (isset($input) && !empty($input));
	}

}