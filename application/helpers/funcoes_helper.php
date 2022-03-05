<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

if ( ! function_exists( 'load_css' ) )
{
	function load_css( $href = '', $media = 'screen' )
	{
		if ( in_array( $media, array( 'all', 'print', 'screen', 'speech' ) ) ) {
			$media = $media;
		} else {
			$media = 'screen';
		}

		$response = '';

		if ( ! empty( $href ) ) {
			$response .= '<link rel="stylesheet" type="text/css" href="'. base_url( $href ) .'" media="' . $media . '">' . "\n";
		}

		return $response;
	}
}

if ( ! function_exists( 'load_js' ) )
{
	function load_js( $src = '' )
	{
		$response = '';

		if ( ! empty( $src ) ) {
			$response .= '<script type="text/javascript" src="'. base_url( $src ) .'"></script>' . "\n";
		}

		return $response;
	}
}

if ( ! function_exists( 'get_messages' ) )
{
	function get_messages( $message = '', $type = 'success', $border = '', $closed = TRUE )
	{
		if ( in_array( $type, array( 'success', 'warning', 'info', 'alert', 'secondary', 'primary' ) ) ) {
			$type = $type;
		} else {
			$type = 'success';
		}

		if ( ! empty( $border ) && in_array( $border, array( 'radius', 'round' ) ) ) {
			$border = ' ' . $border;
		} else {
			$border = '';
		}

		$response = '';

		if ( ! empty( $message ) ) {
			$response .= '<div data-alert class="alert-box '. $type . $border .'">';
			$response .= strip_tags( addslashes( trim( $message ) ), '<strong>' );
			if ( $closed ) {
				$response .= '<a href="" class="close">&times;</a>';
			}
			$response .= '</div>';
		}

		return $response;
	}
}

if ( ! function_exists( 'ci_rand' ) ) {
	function ci_rand( $length = 10 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvxzwyABCDEFGHIJKLMNOPQRSTUVXZWY';
		$charactersLength = strlen( $characters );
		$response = '';

		for ( $i = 0; $i < $length; $i++ ) {
			$response .= $characters[ rand( 0, $charactersLength - 1 ) ];
		} 

		return $response;
	}
}

if ( ! function_exists( 'getMessages' ) ) 
{
	function getMessages( $message = '', $type = 'success' )
	{
		if ( in_array( $type, array( 'success', 'info', 'danger', 'warning' ) ) ) {
			$type = $type;
		} else {
			$type = 'success';
		}

		$response = '';

		if ( ! empty( $message ) ) {
			$response .= '<div class="alert alert-'. $type .' alert-dismissible" role="alert" style="border-radius: 0px !important;">';
			$response .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
			$response .= strip_tags( addslashes( trim( $message ) ), '<strong>' );
			$response .= '</div>';
		}

		return $response;
	}
}


if ( ! function_exists( 'auditoria' ) ) {
	function auditoria( $label = '', $description = '' ) {
		$ci =& get_instance();

		$ci->load->library( array( 'session' ) );
		$ci->load->model( 'Auditoria_model', 'auditoria' );

		$query = $ci->db->last_query();
		$query = strip_tags( addslashes( trim( $query ) ) );


		if ( $ci->session->has_userdata( 'user' ) ) {
			$user = $ci->session->userdata( 'user' )['hash'];
			$user = strip_tags( addslashes( trim( $user ) ) );
		} else {
			$user = '';
		}

		if ( ! empty( $label ) ) {
			$label = strip_tags( addslashes( trim( $label ) ), '<strong>' );
			$label = htmlentities( $label );
		} else {
			$label = '';
		}

		if ( ! empty( $description ) ) {
			$description = strip_tags( addslashes( trim( $description ) ), '<strong>' );
			$description = htmlentities( $description );
		} else {
			$description = '';
		}

		$ci->auditoria->insert( array(
			'query' => $query,
			'author' => $user,
			'label' => $label,
			'description' => $description,
			'hash' => ci_rand(48),
			'created_at' => date( 'Y-m-d H:i:s' )
		) );
	}
}

if ( ! function_exists( 'get_nivel' ) ) {
	function get_nivel( $nivel = 0 ) {
		$nivel = intval( $nivel );
		$niveis = array(
			'1' => 'Administrador',
			'2' => 'Editor'
		);

		if ( $nivel != 0 && in_array( $nivel, array_keys( $niveis ) ) ) {
			return $niveis[ $nivel ];
		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'get_status' ) ) {
	function get_status( $status = 0 ) {
		$status = intval( $status );
		$status_labels = array(
			'0' => 'Inativo',
			'1' => 'Ativo'
		);

		if ( $status != 0 && in_array( $status, array_keys( $status_labels ) ) ) {
			return $status_labels[ $status ];
		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'is_admin' ) ) {
	function is_admin() {
		$ci =& get_instance();
		$ci->load->library( 'session' );

		if ( $ci->session->has_userdata( 'user' ) && $ci->session->userdata('user')['logged'] === TRUE ) {
			$user = $ci->session->userdata('user');
			
			if ( isset( $user['nivel'] ) && intval( $user['nivel'] ) === 1 ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}