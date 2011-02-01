<?php

class PrettyException extends Exception
{
	// Overload Exception::__construct so we can pass it data.
	public function __construct($message, array $params = null)
	{
		// 1. Returns a pretty exception message.
		$message = !empty($params) ? vsprintf($message, $params) : $message;

		// 2. Don't trust it. Remove XSS and spam.
		$message = filter_var($message, FILTER_SANITIZE_STRIPPED, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_ENCODE_HIGH);

		parent::__construct($message, 0);
	}
}


