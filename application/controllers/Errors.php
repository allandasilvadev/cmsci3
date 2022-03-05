<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Errors extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->render( 'painel/errors/404' );
	}
}