<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Auditoria_model extends MY_Model
{
	public $_table = 'auditoria';
	public $primary_key = 'id';
	protected $return_type = 'array';
}