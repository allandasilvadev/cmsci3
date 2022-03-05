<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Views extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Posts_model', 'posts' );
		$this->load->model( 'Paginas_model', 'paginas' );
		$this->load->model( 'Views_model', 'views' );
		$this->load->model( 'Infos_model', 'infos' );

		$this->data['views'] = $this->views->get_all();
		$this->data['infos'] = $this->infos->get_all();
	}

	public function index()
	{
		$this->data['method'] = 'início';
		$this->render( 'painel/views/index' );
	}

	public function infos()
	{
		$this->data['method'] = 'infos';
		$this->render( 'painel/views/infos' );
	}
}