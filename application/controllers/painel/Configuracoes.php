<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Configuracoes extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Configuracoes_model', 'configuracoes' );
		$this->data['configuracoes'] = $this->configuracoes->get_all();
	}

	public function index()
	{
		$this->data['method'] = 'início';		
		$this->render( 'painel/configuracoes/index' );
	}

	public function cadastrar()
	{
		$this->data['method'] = 'cadastrar';
		$this->render( 'painel/configuracoes/cadastrar' );
	}

	public function store()
	{
		if ( $this->input->post( 'cadastrar_configuracoes', TRUE ) ) {
			$dados = array();

			if ( $this->input->post( 'custom_guia', TRUE ) ) {
				$this->form_validation->set_rules( 'custom_guia', 'Guia customizada', 'required|min_length[4]' );
			} else {
				$this->form_validation->set_rules( 'guia', 'Guia', 'required|in_list[phone,mail,address]', array( 'in_list' => 'A guia informada não é válida.' ) );
			}
			
			$this->form_validation->set_rules( 'configuracao', 'Configuração', 'required' );
			$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array( 'in_list' => 'O status informado não é válido.' ) );

			$success = $this->form_validation->run();

			if ( $success ) {

				if ( $this->input->post( 'custom_guia', TRUE ) ) {
					$dados['guia'] = $this->input->post( 'custom_guia', TRUE );
					$dados['guia'] = strip_tags( addslashes( trim( $dados['guia'] ) ) );
					$dados['guia'] = $this->slugify->slugify( $dados['guia'] );
				} else {
					$dados['guia'] = $this->input->post( 'guia', TRUE );
					$dados['guia'] = strip_tags( addslashes( trim( $dados['guia'] ) ) );
				}
				

				$dados['dados'] = strip_tags( addslashes( trim( $this->input->post( 'configuracao' ) ) ) );
				$dados['dados'] = htmlentities( $dados['dados'] );
				$dados['status'] = strip_tags( addslashes( trim( $this->input->post( 'status', TRUE ) ) ) );
				$dados['author'] = $this->session->userdata('user')['hash'];
				$dados['hash'] = ci_rand(48);
				$dados['created_at'] = $this->now;

				$inserir = $this->configuracoes->insert( $dados );


				auditoria( 'Nova configuração cadastrada.', 'Um nova configuração foi cadastrada pelo usuário <strong>' . $this->session->userdata('user')['nome'] . '</strong>' );

				if ( $inserir ) {
					$this->session->set_flashdata( 'configuracoes_messages', 'Configuração cadastrada com sucesso.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'success' );
					redirect( base_url( 'painel/configuracoes' ) );
				} else {
					$this->session->set_flashdata( 'configuracoes_messages', 'Não foi possível cadastrar a configuração.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'danger' );
					redirect( base_url( 'painel/configuracoes' ) );
				}

			} else {
				$this->cadastrar();
			}

		} else {
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}

	public function editar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$configuracao = $this->configuracoes->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $configuracao != null ) {
				$this->data['method'] = 'editar';
				$this->data['configuracao'] = $configuracao;
				$this->render( 'painel/configuracoes/editar' );

			} else {
				redirect( base_url( 'painel/configuracoes' ) );
			}
		} else {
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}

	public function update() {
		if ( $this->input->post( 'editar_configuracoes', TRUE ) ) {
			$hash = strip_tags( addslashes( trim( $this->input->post( 'configuracoes_hash', TRUE ) ) ) );
			$setting = $this->configuracoes->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $setting != null ) {
				$dados = array();

				if ( $this->input->post( 'custom_guia', TRUE ) ) {
					$this->form_validation->set_rules(
						'custom_guia',
						'Guia customizada',
						'required|min_length[4]'
					);
				} else {
					$this->form_validation->set_rules( 
						'guia', 
						'Guia', 
						'required|in_list[phone,mail,address]', 
						array( 'in_list' => 'A guia informada não é válida.' ) 
					);
				}
				

				$this->form_validation->set_rules( 
					'configuracao', 
					'Configuração', 
					'required' 
				);

				$this->form_validation->set_rules( 
					'status', 
					'Status', 
					'required|in_list[published,no-published]', 
					array( 'in_list' => 'O status informado não é válido.' ) 
				);

				$success = $this->form_validation->run();

				if ( $success ) {
					if ( $this->input->post( 'custom_guia', TRUE ) ) {
						$dados['guia'] = $this->input->post( 'custom_guia', TRUE );
						$dados['guia'] = strip_tags( addslashes( trim( $dados['guia'] ) ) );
						$dados['guia'] = $this->slugify->slugify( $dados['guia'] );
					} else {
						$dados['guia'] = $this->input->post( 'guia', TRUE );
						$dados['guia'] = strip_tags( addslashes( trim( $dados['guia'] ) ) );
					}
					

					$dados['dados'] = strip_tags( addslashes( trim( $this->input->post( 'configuracao' ) ) ) );
					$dados['dados'] = htmlentities( $dados['dados'] );

					$dados['status'] = strip_tags( addslashes( trim( $this->input->post( 'status', TRUE ) ) ) );

					$dados['updated_at'] = $this->now;

					$settingid = intval( $setting['id'] );

					$update = $this->configuracoes->update( $settingid, $dados );

					if ( $update ) {
						$this->session->set_flashdata( 'configuracoes_messages', 'Configuração editada com sucesso.' );
						$this->session->set_flashdata( 'configuracoes_messages_type', 'success' );
						redirect( base_url( 'painel/configuracoes' ) );
					} else {
						$this->session->set_flashdata( 'configuracoes_messages', 'Não foi possível editar a configuração.' );
						$this->session->set_flashdata( 'configuracoes_messages_type', 'danger' );
						redirect( base_url( 'painel/configuracoes' ) );
					}


				} else {
					$this->editar( $setting['hash'] );
				}

			} else {
				redirect( base_url( 'painel/configuracoes' ) );
			}

		} else {
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}

	public function excluir( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$config = $this->configuracoes->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $config != null ) {
				$this->data['method'] = 'excluir';
				$this->data['config'] = $config;
				$this->render( 'painel/configuracoes/excluir' );
			} else {
				redirect( base_url( 'painel/configuracoes' ) );
			}
		} else {
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}

	public function send_trash( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$config = $this->configuracoes->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $config != null ) {
				$configid = intval( $config['id'] );
				$update = $this->configuracoes->update( $configid, array( 'deleted_at' => $this->now ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Configuração movida para a lixeira com sucesso.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'success' );
					redirect( base_url( 'painel/configuracoes' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Não foi possível mover a configuração para lixeira.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'danger' );
					redirect( base_url( 'painel/configuracoes' ) );
				}	
			} else {
				redirect( base_url( 'painel/configuracoes' ) );
			}
		} else {
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}

	public function restaurar( $hash = '' )
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$config = $this->configuracoes->get_by( array( 'hash' => $hash, 'deleted_at !=' => NULL ) );

			if ( $config != null )
			{
				$configid = intval( $config['id'] );
				$update = $this->configuracoes->update( $configid, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Configuração restaurada com sucesso.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'success' );
					redirect( base_url( 'painel/configuracoes' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Não foi possível restaurar a configuração.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'danger' );
					redirect( base_url( 'painel/configuracoes' ) );
				}	
			} 
			else 
			{
				redirect( base_url( 'painel/configuracoes' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}


	public function destroy( $hash = '' )
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$config = $this->configuracoes->get_by( array( 'hash' => $hash ) );

			if ( $config != null )
			{
				$delete = $this->configuracoes->delete( intval( $config['id'] ) );

				if ( $this->db->affected_rows() > 0 )
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Configuração excluída com sucesso.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'info' );
					redirect( base_url( 'painel/configuracoes' ) );
				}
				else 
				{
					$this->session->set_flashdata( 'configuracoes_messages', 'Não foi possível excluir a configuração.' );
					$this->session->set_flashdata( 'configuracoes_messages_type', 'danger' );
					redirect( base_url( 'painel/configuracoes' ) );
				}
			}
			else 
			{
				redirect( base_url( 'painel/configuracoes' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/configuracoes' ) );
		}
	}
}