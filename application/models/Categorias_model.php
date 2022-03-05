<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Categorias_model extends MY_Model
{
	public $_table = 'categorias';
	public $primary_key = 'id';
	protected $return_type = 'array';

	public function updateMany( $where = array(), $dados = array() )
	{
		if ( is_array( $where ) && sizeof( $where ) > 0 ) {
			if ( is_array( $dados ) && sizeof( $dados ) > 0 ) {
				$this->db->where( $where );
				$this->db->update( $this->_table, $dados );

				if ( $this->db->affected_rows() > 0 ) {
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function deleteOne( $where = array() )
	{
		if ( is_array( $where ) && sizeof( $where ) > 0 ) {
			$this->db->where( $where );
			$this->db->limit( 1 );
			$this->db->delete( $this->_table );

			if ( $this->db->affected_rows() > 0 ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function updateOne( $where = array(), $dados = array() )
	{
		if ( is_array( $where ) && sizeof( $where ) > 0 ) 
		{
			if ( is_array( $dados ) && sizeof( $dados ) > 0 ) 
			{
				$this->db->where( $where );
				$this->db->limit( 1 );
				$this->db->update( $this->_table, $dados );

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
		else 
		{
			return FALSE;
		}
	}

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