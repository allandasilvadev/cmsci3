<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

use Cocur\Slugify\Slugify;

class MY_Controller extends CI_Controller
{
	public $data = array();
	protected $now;
	protected $slugify;

	public function __construct()
	{
		parent::__construct();

		$this->slugify = new Slugify();

		$this->load->helper( array( 'url', 'form' ) );
		$this->load->helper( array( 'funcoes', 'painel' ) );

		$this->load->library( array( 'form_validation' ) );

		$this->now = date( 'Y-m-d H:i:s' );
		$this->data['title'] = 'Painel | Infohunters';
		$this->data['method'] = '';

		$this->load->model( 'Usuarios_model', 'usuarios' );
		$this->data['users'] = $this->usuarios->get_all();	

		$this->load->model( 'Auditoria_model', 'auditoria' );
		$this->data['auditoria'] = $this->auditoria->get_all();	
	}

	protected function render( $container = '', $layout = '' ) 
	{
		$this->data['container'] = $this->load->view( $container, $this->data, TRUE );
		$this->load->view( $layout, $this->data );
	}
}

class Frontend_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function render( $container = '', $layout = 'layouts/frontend' )
	{
		parent::render( $container, $layout );
	}
}

class Backend_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ( $this->session->has_userdata( 'user' ) && $this->session->userdata('user')['logged'] === TRUE ) {

		} else {
			$exception_uris = array(
				'painel',
				'painel/usuarios/login',
				'painel/usuarios/logar',
				'painel/usuarios/sair',
				'painel/usuarios/recuperarSenha',
				'painel/usuarios/send_recovery_password',
				'painel/usuarios/recuperar_senha_post',
				'painel/migrate',
				'painel/migrate/index'
			);

			http://localhost/aulas/infohunters/painel/usuarios/editarSenha/wsYsFvLc6HkVMeWkDwwx52ib9RVSuqpR46DuH3vs6sDrnNfeqqTrIu5Nkq5BYtK1ROwx/maria.dev@gmail.com/reiniciar

			if ( in_array( $this->uri->uri_string(), $exception_uris ) ) {

			} else {
				if ( strtolower( $this->router->fetch_class() ) === 'usuarios' && strtolower( $this->router->fetch_method() ) === 'editarsenha' ) {

				} else {
					$this->session->unset_userdata( 'user' );
					redirect( base_url( 'painel/usuarios/login' ) );
				}
				
			}			
		}
	}

	protected function render( $container = '', $layout = 'painel/layouts/backend' )
	{
		parent::render( $container, $layout );
	}
}