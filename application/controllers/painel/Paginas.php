<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Paginas extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Paginas_model', 'paginas' );
		$this->data['paginas'] = $this->paginas->get_all();
	}

	public function index()
	{
		$this->data['method'] = 'início';
		$this->render( 'painel/paginas/index' );
	}

	public function cadastrar()
	{
		$this->data['method'] = 'cadastrar';
		$this->render( 'painel/paginas/cadastrar' );
	}

	public function reorderpost()
	{
	    if ( $this->input->post( '_order', TRUE ) ) 
	    {
	    	$order = $this->input->post( '_order', TRUE );

	    	foreach ( $order as $key => $value ) {
	    		$paginaid = intval( $value );
	    		$this->paginas->update( $paginaid, array( '_order' => $key ) );
	    	}

	    	exit;

	    }
	}

	public function reorder()
	{		
		$this->data['method'] = 'reorder';
		$this->data['paginas'] = $this->paginas->get_order();
		$this->render( 'painel/paginas/reorder' );
	}

	public function store()
	{
		if ( $this->input->post( 'paginas_cadastrar', TRUE ) ) {
			$dados = array();
			$this->form_validation->set_rules( 'title', 'Title', 'required|min_length[4]|is_unique[paginas.title]' );

			if ( $this->input->post( 'slug', TRUE ) ) {
				$this->form_validation->set_rules( 'slug', 'Slug', 'min_length[4]|is_unique[paginas.slug]' );
			}

			if ( $this->input->post( 'order', TRUE ) ) {
				$this->form_validation->set_rules( 'order', 'Order', 'numeric' );
			}

			$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array(
				'in_list' => 'O status informado não é válido.'
			) );

			if ( $this->input->post( 'isHome', TRUE ) ) {
				$this->form_validation->set_rules( 'isHome', '', 'numeric|in_list[1]', array(
					'numeric' => 'O valor informado deve ser YES ou NO',
					'in_list' => 'O valor informado deve ser YES ou NO'
				) );
			}

			$this->form_validation->set_rules( 'body', 'Body', 'required|min_length[6]' );

			$success = $this->form_validation->run();

			if ( $success ) {
				$dados['title'] = strip_tags( addslashes( trim( $this->input->post( 'title', TRUE ) ) ) );
				$dados['slug']  = $this->slugify->slugify( $dados['title'] );
				$dados['title'] = htmlentities( $dados['title'] );

				if ( $this->input->post( 'order', TRUE ) ) {
					$dados['_order'] = $this->input->post( 'order', TRUE );
				} else {
					$dados['_order'] = '0';
				}

				$dados['status'] = $this->input->post( 'status', TRUE );
				$dados['author'] = $this->session->userdata('user')['hash'];
				$dados['body'] = $this->input->post( 'body', FALSE );

				if ( $this->input->post( 'isHome', TRUE ) ) {
					$dados['isHome'] = '1';
				} else {
					$dados['isHome'] = '0';
				}

				$dados['hash'] = ci_rand(48);
				$dados['created_at'] = $this->now;

				$inserir = $this->paginas->insert( $dados );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'paginas_messages', 'Página cadastrada com sucesso.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'success' );
					redirect( base_url( 'painel/paginas' ) );
				} else {
					$this->session->set_flashdata( 'paginas_messages', 'Não foi possível cadastrar a página.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'danger' );
					redirect( base_url( 'painel/paginas' ) );
				}

			} else {
				$this->cadastrar();
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}

	public function editar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $pagina != null ) {
				$this->data['method'] = 'editar';
				$this->data['pagina'] = $pagina;
				$this->render( 'painel/paginas/editar' );
			} else {
				redirect( base_url( 'painel/paginas' ) );
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}

	public function update() {
		if ( $this->input->post( 'paginas_editar', TRUE  ) ) {
			$hash = strip_tags( addslashes( trim( $this->input->post( 'paginas_hash', TRUE ) ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $pagina != null ) {
				$dados = array();

				if ( $this->input->post( 'title', TRUE ) != $pagina['title'] ) {
					$this->form_validation->set_rules( 
						'title', 
						'Title', 
						'required|min_length[4]|is_unique[paginas.title]' 
					);
				} else {
					$this->form_validation->set_rules( 
						'title', 
						'Title', 
						'required|min_length[4]' 
					);
				}				

				if ( $this->input->post( 'slug', TRUE ) != $pagina['slug'] ) 
				{
					$this->form_validation->set_rules( 
						'slug', 
						'Slug', 
						'min_length[4]|is_unique[paginas.slug]' 
					);
				} 
				else 
				{
					$this->form_validation->set_rules( 
						'slug', 
						'Slug', 
						'min_length[4]' 
					);
				}

				if ( $this->input->post( 'order', TRUE ) ) 
				{
					$this->form_validation->set_rules( 'order', 'Order', 'numeric' );
				}

				$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array(
					'in_list' => 'O status informado não é válido.'
				) );

				if ( $this->input->post( 'isHome', TRUE ) ) {
					$this->form_validation->set_rules( 'isHome', '', 'numeric|in_list[1]', array(
						'numeric' => 'O valor informado deve ser YES ou NO',
						'in_list' => 'O valor informado deve ser YES ou NO'
					) );
				}

				$this->form_validation->set_rules( 'body', 'Body', 'required|min_length[6]' );

				$success = $this->form_validation->run();

				if ( $success ) {

					$dados['title'] = html_entity_decode( $this->input->post( 'title', TRUE ) );
					$dados['title'] = strip_tags( addslashes( trim( $this->input->post( 'title', TRUE ) ) ) );
					$dados['slug']  = $this->slugify->slugify( $dados['title'] );
					$dados['title'] = htmlentities( $dados['title'] );

					if ( $this->input->post( 'order', TRUE ) ) {
						$dados['_order'] = $this->input->post( 'order', TRUE );
					} else {
						$dados['_order'] = '0';
					}

					$dados['status'] = $this->input->post( 'status', TRUE );

					if ( $this->input->post( 'isHome', TRUE ) ) {
						$dados['isHome'] = '1';
					} else {
						$dados['isHome'] = '0';
					}

					$dados['body'] = $this->input->post( 'body', FALSE );

					$dados['updated_at'] = $this->now;

					$paginaid = intval( $pagina['id'] );

					$update = $this->paginas->update( $paginaid, $dados );

					if ( $this->db->affected_rows() > 0 ) {
						$this->session->set_flashdata( 'paginas_messages', 'Página editada com sucesso.' );
						$this->session->set_flashdata( 'paginas_messages_type', 'success' );
						redirect( base_url( 'painel/paginas' ) );
					} else {
						$this->session->set_flashdata( 'paginas_messages', 'Não foi possível editar a página.' );
						$this->session->set_flashdata( 'paginas_messages_type', 'danger' );
						redirect( base_url( 'painel/paginas' ) );
					}

				} else {
					$this->editar( $pagina['hash'] );
				}
			} else {
				redirect( base_url( 'painel/paginas' ) );
			}		

		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}


	public function deletar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $pagina != null ) {
				$this->data['method'] = 'deletar';
				$this->data['pagina'] = $pagina;
				$this->render( 'painel/paginas/deletar' );
			} else {
				redirect( base_url( 'painel/paginas' ) );
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}

	public function destroy( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash ) );

			if ( $pagina != null ) {
				$paginaid = intval( $pagina['id'] );
				$deletar = $this->paginas->delete( $paginaid );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Página excluída com sucesso.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'success' );
					redirect( base_url( 'painel/paginas' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Não foi possível excluir a página.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'danger' );
					redirect( base_url( 'painel/paginas' ) );
				}

			} else {
				redirect( base_url( 'painel/paginas' ) );
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}

	public function send_trash( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash ) );

			if ( $pagina != null ) {
				$paginaid = intval( $pagina['id'] );
				$update = $this->paginas->update( $paginaid, array( 'deleted_at' => $this->now ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Página movida para lixeira com sucesso.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'success' );
					redirect( base_url( 'painel/paginas' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Não foi possível mover a página para lixeira.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'danger' );
					redirect( base_url( 'painel/paginas' ) );
				}
			} else {
				redirect( base_url( 'painel/paginas' ) );
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}


	public function restaurar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$pagina = $this->paginas->get_by( array( 'hash' => $hash ) );

			if ( $pagina != null ) {
				$paginaid = intval( $pagina['id'] );
				$update = $this->paginas->update( $paginaid, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Página restaurada com sucesso.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'success' );
					redirect( base_url( 'painel/paginas' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'paginas_messages', 'Não foi possível restaurar a página.' );
					$this->session->set_flashdata( 'paginas_messages_type', 'danger' );
					redirect( base_url( 'painel/paginas' ) );
				}
			} else {
				redirect( base_url( 'painel/paginas' ) );
			}
		} else {
			redirect( base_url( 'painel/paginas' ) );
		}
	}
}