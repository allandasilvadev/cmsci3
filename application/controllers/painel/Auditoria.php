<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Auditoria extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ( ! is_admin() ) {
			auditoria( 
				'Um usuário não autorizado tentou acessar a auditoria.', 
				'O usuário <strong>'. html_entity_decode( $this->session->userdata('user')['nome'] ) .'</strong> tentou acessar a auditoria do sistema.'
			);

			$this->session->set_flashdata( 'paginas_messages', 'Você não tem permissão para acessar essa página.' );
			$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
			redirect( base_url( 'painel/paginas' ) );
		}
	}

	public function index()
	{
		$this->data['method'] = 'início';
		$this->render( 'painel/auditoria/index' );
	}

	public function visualizar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$aud = $this->auditoria->get_by( array( 'hash' => $hash ) );

			if ( $aud != null ) {
				$this->data['method'] = 'visualizar';
				$this->data['aud'] = $aud;
				$this->render( 'painel/auditoria/visualizar' );
			} else {
				redirect( base_url( 'painel/auditoria' ) );
			}
		} else {
			redirect( base_url( 'painel/auditoria' ) );
		}
	}
}