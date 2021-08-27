<?php defined('BASEPATH') or exit('No direct script access allowed');

if (! function_exists('success')) {
	function success($text) {
		$alert = "
			<div id='notif' class='alert alert-success alert-dismissible fade show' role='alert'>
			$text
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>
		";

		return $alert;
	}
}

if (! function_exists('warning')) {
	function warning($text) {
		$alert = "
			<div id='notif' class='alert alert-warning alert-dismissible fade show' role='alert'>
			$text
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>
		";


		return $alert;
	}
}

if (! function_exists('error')) {
	function error($text) {
		$alert = "
			<div id='notif' class='alert alert-danger alert-dismissible fade show' role='alert'>
			$text
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>
		";


		return $alert;
	}
}