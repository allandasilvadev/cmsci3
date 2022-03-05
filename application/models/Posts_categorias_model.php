<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}


class Posts_categorias_model extends MY_Model
{
	public $_table = 'posts_categorias';
	public $primary_key = 'id';
	protected $return_type = 'array';

	public function deleteMany( $where = array() ) 
	{
		if ( is_array( $where ) && sizeof( $where ) > 0 ) 
		{
			$this->db->delete( $this->_table, $where );

			if ( $this->db->affected_rows() > 0 ) 
			{
				return TRUE;
			} 
			else 
			{
				return FALSE;
			}
		} 
		else 
		{
			return FALSE;
		}
	}
}