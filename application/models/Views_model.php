<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Views_model extends MY_Model
{
	public $_table = 'views';
	public $primary_key = 'id';
	protected $return_type = 'array';
}