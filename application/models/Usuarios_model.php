<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Usuarios_model extends MY_Model
{
	public $_table = 'usuarios';
	public $primary_key = 'id';
	protected $return_type = 'array';

	public function logar( array $dados ) {
		if ( is_array( $dados ) && sizeof( $dados ) > 0 ) {
			$user = $this->get_by( array(
				'login' => $dados['login'],
				'senha' => $dados['senha'],
				'status' => '1'
			) );

			if ( $user != null ) {
				return $user;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	} 

	public function getOne( $where = array() ) {
		if ( is_array( $where ) && sizeof( $where ) > 0 ) {
			$this->db->where( $where );
			$this->db->limit(1);
			$query = $this->db->get( $this->_table );
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
}