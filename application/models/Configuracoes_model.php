<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Configuracoes_model extends MY_Model
{
	public $_table = 'configuracoes';
	public $primary_key = 'id';
	protected $return_type = 'array';

	public function getMany( $where = array() )
	{
		if ( is_array( $where ) && sizeof( $where ) > 0 )
		{
			$this->db->where( $where );
			$query = $this->db->get( $this->_table );
			return $query->result_array();
		}
		else 
		{
			return FALSE;
		}
	}
}