<?php 

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

if ( ! function_exists( 'clear' ) ) {
	function clear( $str = '', $htmlentities = TRUE ) {
		if ( ! empty( $str ) ) {
			$str = strip_tags( addslashes( trim( $str ) ) );

			if ( $htmlentities === TRUE ) {
				$str = htmlentities( $str );
			}

			return $str;
		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'btn_edit' ) ) {
	function btn_edit( $uri = '', $label = 'Editar' ) {
		if ( ! empty( $uri ) ) {

			$response = '';

			$response .= '<a href="'. $uri .'" class="btn btn-info" style="margin-right: 3.8%;">';
				$response .= '<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>&nbsp;';
				$response .= clear( $label );
			$response .= '</a>';

			return $response;

		} else {
			return FALSE;
		}
	}
}


if ( ! function_exists( 'btn_delete' ) ) {
	function btn_delete( $uri = '', $label = 'Remover' ) {
		if ( ! empty( $uri ) ) {

			$response = '';

			$response .= '<a href="'. $uri .'" class="btn btn-danger">';
				$response .= '<i class="fa fa-fw fa-times" aria-hidden="true"></i>&nbsp;';
				$response .= clear( $label );
			$response .= '</a>';

			return $response;

		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'btn_restore' ) ) {
	function btn_restore( $uri = '', $label = 'Restaurar' ) {
		if ( ! empty( $uri ) ) {

			$response = '';
			
			$response .= '<a href="'. $uri .'" class="btn btn-warning">';
				$response .= '<i class="fa fa-fw fa-undo" aria-hidden="true"></i>&nbsp;';
				$response .= clear( $label );
			$response .= '</a>';

			return $response;

		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'btn_cancel' ) ) {
	function btn_cancel( $uri = '', $label = 'Cancelar' ) {
		if ( ! empty( $uri ) ) {

			$response = '';

			$response .= '<a href="'. $uri .'" class="btn btn-success">';
				$response .= '<i class="fa fa-fw fa-undo" aria-hidden="true"></i>&nbsp;';
				$response .= 'Cancelar';
			$response .= '</a>';

			return $response;

		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'btn_send_trash' ) ) {
	function btn_send_trash( $type = '', $name = '', $label = '' ) {

		if ( ! empty( $name ) ) {
			
			$response = '';

			$type = clear( $type );
			$name = clear( $name );
			$label = clear( $label );

			$response .= '<button type="'. $type .'" name="'. $name .'" id="'. $name .'" class="btn btn-warning pull-left" style="margin-right: 0.72%;" value="'. $label .'">';
				$response .= '<i class="fa fa-fw fa-trash" aria-hidden="true"></i>&nbsp;';
				$response .= $label;
			$response .= '</button>';

			return $response;

		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'btn_del' ) ) {
	function btn_del( $name = '', $type = 'submit', $label = 'Excluir' ) {

		if ( ! empty( $name ) ) {

			$response = '';

			$name = clear( $name );
			$type = clear( $type );
			$label = clear( $label );

			$response .= '<button type="'. $type .'" name="'. $name .'" id="'. $name .'" class="btn btn-danger pull-left" style="margin-right: 0.72%;" value="'. $label .'">';
				$response .= '<i class="fa fa-fw fa-times" aria-hidden="true"></i>&nbsp;';
				$response .= $label;
			$response .= '</button>';

			return $response;

		} else {
			return FALSE;
		}

	}
}

if ( ! function_exists( 'get_notificacao' ) ) {
	function get_notificacao( $session_id = '', $session_type = '' ) {
		$ci =& get_instance();
		$ci->load->helper( 'funcoes' );
		$ci->load->library( array( 'session' ) );

		if ( $ci->session->flashdata( $session_id ) ) {
			if ( $ci->session->flashdata( $session_type ) ) {
				$type = $ci->session->flashdata( $session_type );
			} else {
				$type = 'success';
			}

			return getMessages( $ci->session->flashdata( $session_id ), $type );
		} else {
			return FALSE;
		}
	}
}

if ( ! function_exists( 'get_errors_messages' ) ) {
	function get_errors_messages( $name = '', $open = '<div class="errors-messages"">', $close = '</div>' ) {
		$ci =& get_instance();
		$ci->load->helper( array( 'form' ) );

		if ( ! empty( $name ) ) {
			return form_error( $name, $open, $close );
		} else {
			return FALSE;
		}
	}
}