<?php


namespace WOF\Core\Exceptions;


use Exception;
use WP_Error;

/*
 * The WOF Exception serves as a general purpose container for errors within the WOF code/
 *
 * 0            Undetermined code
 * 1000-1999    Application Errors 1001
 * 2000-2999    Database Errors 2003
 * 3000-3999    Remote Request / API Errors 3002
 *
 * 9000+        Misc Errors (Over 9000)
 *
 */
class WofException extends Exception {
	protected array $errorData;

	/**
	 * Construct the exception.
	 *
	 * @param string $message The Exception message to throw.
	 * @param int $code [optional] The Exception code.
	 * @param array|null $data [optional] An array of additional data dependent on the error type.
	 * @param Exception|null $previous [optional] The previous throwable used for the exception chaining.
	 */
	public function __construct(string $message, int $code = 0, array $data = null, Exception $previous = null) {

		if (isset($data)) {
			$this->errorData = $data;
		} else {
			$this->errorData = array();
		}

		if (!isset($this->errorData['source'])) {
			$this->errorData['source'] = 'default';
		}

		parent::__construct($message, $code, $previous);
	}


	/**
	 * Factory method for creating error data from a WP_Error object
	 *
	 * @param WP_Error $wpError A WP_Error object to be used for creating the exception
	 *
	 * @return array additional data from the WP_Error. Returns a blank array if the WP_error object is empty.
	 *
	 * source: Will always equal 'WP_Error'
	 * wp_error_codes: The WP error codes in the object.
	 * wp_error_messages: The WP error messages in the object.
	 */
	public static function getErrorDataFromWpError(WP_Error $wpError) : array {
		if (!is_wp_error($wpError) || !$wpError->has_errors()) {
			return array();
		}

		$data = array();
		$data['source'] = 'WP_Error';
		$data['wp_error_codes'] = $wpError->get_error_codes();
		$data['wp_error_messages'] = $wpError->get_error_messages();

		return $data;
	}

	/**
	 * A factory method for creating error data from wp_remote_requests
	 *
	 * @param string $statusCode The status code of the HTTP response
	 * @param array $body The body of the HTTP response
	 *
	 * @return array additional data from the remote response.
	 *
	 * source: Will always equal 'wp_remote_request'
	 * status_code: HTTP status code returned from the response.
	 * response_body: The plaintext body from the response.
	 */
	public static function getErrorDataFromRemoteResponse(string $statusCode, array $body) : array {

		$data = array();
		$data['source'] = 'wp_remote_request';
		$data['status_code'] = $statusCode;
		$data['response_body'] =$body;

		return $data;
	}

	/**
	 * Get the error data array.
	 *
	 * @return array An array of the data from the error. ['source'] will be filled with the error's source.
	 */
	public function getData () : array {
		return $this->errorData;
	}


	public function __toString() : string {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}
