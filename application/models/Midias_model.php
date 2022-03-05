<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Midias_model extends MY_Model
{
	public $_table = 'midias';
	public $primary_key = 'id';
	protected $return_type = 'array';

	public function pegar_images( $arq = NULL ) {
		if ( $arq != NULL ) {
			$get_images = $this->db->like( 'legenda', $arq )->limit(10);
		} else {
			$get_images = $this->db->limit(10);
		}
		
		$get_images = $this->db->get( $this->_table );

		$dados['total_rows'] = $this->db->get( $this->_table )->num_rows();
		$dados['result']     = $get_images->result_array();

		return $dados; 
	}

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