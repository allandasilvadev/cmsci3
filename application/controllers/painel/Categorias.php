<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Categorias extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Categorias_model', 'categorias' );
		$this->load->model( 'Posts_categorias_model', 'posts_categorias' );
		$this->load->model( 'Posts_model', 'posts' );

		$this->data['categorias'] = $this->categorias->get_all();
	}

	public function index()
	{
		$this->data['method'] = 'início';
		$this->render( 'painel/categorias/index' );
	}

	public function cadastrar()
	{
		$this->data['method'] = 'cadastrar';
		$this->render( 'painel/categorias/cadastrar' );
	}

	public function inserir()
	{
		if ( $this->input->post( 'cadastrar_categorias', TRUE ) ) {
			$dados = array();

			$this->form_validation->set_rules( 'label', 'Label', 'required|min_length[4]' );
			$this->form_validation->set_rules( 'author', 'Author', 'required' );
			$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array(
				'in_list' => 'O status informado não é válido.'
			));

			if ( $this->input->post( 'description', TRUE ) ) {
				$this->form_validation->set_rules( 'description', 'Sobre a categoria', 'min_length[6]' );
			}

			$success = $this->form_validation->run();

			if ( $success ) {
				$dados['label'] = strip_tags( addslashes( trim( $this->input->post( 'label' ) ) ) );
				$dados['slug'] = $this->slugify->slugify( $dados['label'] );
				$dados['label'] = htmlentities( $dados['label'] );

				if ( $this->input->post( 'description' ) ) {
					$dados['description'] = strip_tags( addslashes( trim( $this->input->post( 'description' ) ) ) );
					$dados['description'] = htmlentities( $dados['description'] );
				} else {
					$dados['description'] = '';
				}

				$dados['author'] = $this->session->userdata('user')['hash'];
				$dados['status'] = $this->input->post( 'status', TRUE );

				if ( $this->input->post( 'parent_category' ) ) {
					$dados['parent_category'] = $this->input->post( 'parent_category', TRUE );
				} else {
					$dados['parent_category'] = '0';
				}

				$dados['hash'] = ci_rand(48);
				$dados['created_at'] = $this->now;

				$inserir = $this->categorias->insert( $dados );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'categorias_messages', 'Categoria cadastrada com sucesso.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'info' );
					redirect( base_url( 'painel/categorias' ) );
				} else {
					$this->session->set_flashdata( 'categorias_messages', 'Não foi possível cadastrar a categoria.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'danger' );
					redirect( base_url( 'painel/categorias' ) );
				}


			} else {
				$this->cadastrar();
			}

		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

	public function editar( $hash = '' ) 
	{
		if ( ! empty( $hash ) ) {
			$categoria = $this->categorias->get_by( array( 'hash' => $hash ) );

			if ( $categoria != null ) {
				$this->data['method'] = 'editar';
				$this->data['categoria'] = $categoria;
				$this->render( 'painel/categorias/editar' );
			} else {
				redirect( base_url( 'painel/categorias' ) );
			}
		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

	public function deletar( $hash = '' ) 
	{
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$categoria = $this->categorias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $categoria != null ) {
				$this->data['method'] = 'deletar';
				$this->data['categoria'] = $categoria;
				$this->render( 'painel/categorias/deletar' );
			} else {
				redirect( base_url( 'painel/categorias' ) );
			}
		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

	public function restaurar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$categoria = $this->categorias->get_by( array( 'hash' => $hash, 'deleted_at !=' => NULL ) );

			if ( $categoria != null ) {
				$categoriaid = intval( $categoria['id'] );

				$this->categorias->update( $categoriaid, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'categorias_messages', 'Categoria restaurada com sucesso.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'success' );
					redirect( base_url( 'painel/categorias' ) );
				} else {
					$this->session->set_flashdata( 'categorias_messages', 'Não foi possível restaurar a categoria.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'danger' );
					redirect( base_url( 'painel/categorias' ) );
				}
			} else {
				redirect( base_url( 'painel/categorias' ) );
			}

		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}


	public function excluir () {
		if ( $this->input->post( 'categorias_excluir', TRUE ) ) {
			$hash = $this->input->post( 'categorias_hash', TRUE );
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$categoria = $this->categorias->get_by( array( 'hash' => $hash ) );

			if ( $categoria != null ) {
				$categoriaid = intval( $categoria['id'] );
				$categorias_hash = strip_tags( addslashes( trim( $categoria['hash'] ) ) );

				if ($this->categorias->get_by(array('parent_category' => $categorias_hash ))) 
				{
					if ( in_array( $this->input->post( 'child_categories', TRUE ), array( 'updated', 'deleted' ) ) ) {
						$child_categories = $this->input->post( 'child_categories', TRUE );
					} else {
						$child_categories = 'updated';
					}
					

					if ( $child_categories === 'deleted' ) {						

						// child category is parent other category ?
						$_child_category = $this->categorias->get_by( array( 'parent_category' => $categorias_hash ) );

						if ( $_child_category != null ) {
							$this->categorias->updateMany( 
								array( 'parent_category' => $_child_category['hash'] ),
								array( 'parent_category' => '' )
							);
						}


						$this->posts_categorias->deleteMany( array( 
							'categorias_id' => intval( $categoria['id'] ) 
						) );

						$this->categorias->deleteOne( 
							array( 'parent_category' => $categorias_hash ) 
						);

					} else if ( $child_categories === 'updated' ) {

						
						$this->categorias->updateMany( 
							array( 'parent_category' => $categorias_hash ), 
							array( 'parent_category' => '' ) 
						);

					} 
				}		

				$this->posts_categorias->deleteMany( array( 
					'categorias_id' => intval( $categoria['id'] ) 
				) );		

				$del_categorias = $this->categorias->delete( $categoriaid );

				if ( $del_categorias ) {
					$this->session->set_flashdata( 'categorias_messages', 'Categoria excluída com sucesso.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'success' );
					redirect( base_url( 'painel/categorias' ) );
				} else {
					$this->session->set_flashdata( 'categorias_messages', 'Não foi possível excluir a categoria.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'danger' );
					redirect( base_url( 'painel/categorias' ) );
				}

			} else {
				redirect( base_url( 'painel/categorias' ) );
			}
		} elseif( $this->input->post( 'categorias_send_trash', TRUE ) ) {

			$hash = $this->input->post( 'categorias_hash', TRUE );
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$categoria = $this->categorias->get_by( array( 'hash' => $hash ) );

			if ( $categoria != null ) {
				$categoriaid = intval( $categoria['id'] );
				$categorias_hash = strip_tags( addslashes( trim( $categoria['hash'] ) ) );

				if ($this->categorias->get_by(array('parent_category' => $categorias_hash ))) 
				{
					if ( in_array( $this->input->post( 'child_categories', TRUE ), array( 'updated', 'deleted' ) ) ) {
						$child_categories = $this->input->post( 'child_categories', TRUE );
					} else {
						$child_categories = 'updated';
					}
					

					if ( $child_categories === 'deleted' ) {						

						// child category is parent other category ?
						$_child_category = $this->categorias->get_by( array( 'parent_category' => $categorias_hash ) );

						if ( $_child_category != null ) {
							$this->categorias->updateMany( 
								array( 'parent_category' => $_child_category['hash'] ),
								array( 'parent_category' => '' )
							);
						}

						$this->categorias->updateOne( 
							array( 'parent_category' => $categorias_hash ), 
							array( 'deleted_at' => $this->now ) 
						);

					} else if ( $child_categories === 'updated' ) {

						// remove child category from categories.
						$this->categorias->updateMany( 
							array( 'parent_category' => $categorias_hash ), 
							array( 'parent_category' => '' ) 
						);

					} 
				}				

				$upd_categorias = $this->categorias->update( intval( $categoria['id'] ), array( 'deleted_at' => $this->now ) );

				if ( $upd_categorias ) {
					$this->session->set_flashdata( 'categorias_messages', 'Categoria enviada para lixeira com sucesso.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'success' );
					redirect( base_url( 'painel/categorias' ) );
				} else {
					$this->session->set_flashdata( 'categorias_messages', 'Não foi possível enviar a categoria para lixeira.' );
					$this->session->set_flashdata( 'categorias_messages_type', 'danger' );
					redirect( base_url( 'painel/categorias' ) );
				}

			} else {
				redirect( base_url( 'painel/categorias' ) );
			}

		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

	public function update() {
		if ( $this->input->post( 'editar_categorias', TRUE ) ) {
			$hash = $this->input->post( 'categorias_hash', TRUE );
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$categoria = $this->categorias->get_by( array( 'hash' => $hash ) );
			
			if ( $categoria != null ) {				
				$dados = array();

				$this->form_validation->set_rules( 'label', 'Label', 'required|min_length[4]' );

				if ( $this->input->post( 'slug', TRUE )  != $categoria['slug'] ) {				
					$this->form_validation->set_rules( 'slug', 'Slug', 'required|min_length[4]|is_unique[categorias.slug]');	
				}
				
				if ( $this->input->post( 'parent_category', TRUE ) ) {
					$this->form_validation->set_rules( 'parent_category', 'Categoria pai', 'callback_categorias_pais' );
				} else {
					$dados['parent_category'] = $this->input->post( 'parent_category', TRUE );
				}

				$this->form_validation->set_rules( 'author', 'Author', 'required|callback_usuarios_validos' );

				$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]' );

				if ( $this->input->post( 'description', TRUE ) ) {
					$this->form_validation->set_rules( 'description', 'Sobre a categoria', 'min_length[6]' );
				}				

				$success = $this->form_validation->run();

				if ( $success ) {					
					$dados['label'] = html_entity_decode( $this->input->post( 'label' ) );
					$dados['label'] = strip_tags( addslashes( trim( $this->input->post( 'label' ) ) ) );

					if ( $this->input->post( 'slug', TRUE ) != $categoria['slug'] ) {
						$slug = strip_tags( addslashes( trim( $this->input->post('slug', TRUE ) ) ) );
						$dados['slug'] = $this->slugify->slugify( $slug );
					} else {
						$dados['slug'] = $this->slugify->slugify( $dados['label'] );
					}

					$dados['label'] = htmlentities( $dados['label'] );

					if ( $this->input->post( 'description', TRUE ) ) {
						$dados['description'] = $this->input->post( 'description', TRUE );
					} else {
						$dados['description'] = '';
					}

					$dados['author'] = $this->input->post( 'author', TRUE );
					$dados['status'] = $this->input->post( 'status', TRUE );

					if ( $this->input->post( 'parent_category', TRUE ) ) {
						$dados['parent_category'] = $this->input->post( 'parent_category', TRUE );
					} else {
						$dados['parent_category'] = '';
					}

					$dados['updated_at'] = $this->now;

					$categoriaid = intval( $categoria['id'] );

					$update = $this->categorias->update( $categoriaid, $dados );

					if ( $this->db->affected_rows() > 0 ) {
						$this->session->set_flashdata( 'categorias_messages', 'Categoria atualizada com sucesso.' );
						$this->session->set_flashdata( 'categorias_messages_type', 'success' );
						redirect( base_url( 'painel/categorias' ) );
					} else {
						$this->session->set_flashdata( 'categorias_messages', 'Não foi possível atualizar a categoria.' );
						$this->session->set_flashdata( 'categorias_messages_type', 'danger' );
						redirect( base_url( 'painel/categorias' ) );
					}
 
				} else {
					$this->editar( $hash );
				}
			} else {
				redirect( base_url( 'painel/categorias/editar/' . $hash ) );
			}			

		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

	public function categorias_pais( $cat = '' ) {
		if ( ! empty( $cat ) ) {
			$categorias = $this->categorias->get_all();
			$categoriasHash = array();

			foreach ( $categorias as $category ) {
				array_push( $categoriasHash, $category['hash'] );
			}

			if ( in_array( $cat, $categoriasHash ) ) {
				return TRUE;
			} else {
				$this->form_validation->set_message( 'categorias_pais', 'Categoria pai não é válida.' );
				return FALSE;
			}
		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	} 	

	public function usuarios_validos( $user = '' ) {
		if ( ! empty( $user ) ) {
			$usuarios = $this->usuarios->get_all();
			$usuarioshash = array();

			foreach ( $usuarios as $usuario ) {
				array_push( $usuarioshash, $usuario['hash'] );
			}

			if ( in_array( $user, $usuarioshash ) ) {
				return TRUE;
			} else {
				$this->form_validation->set_message( 'usuarios_validos', 'O usuário informado não é válido.' );
				return FALSE;
			}
		} else {
			redirect( base_url( 'painel/categorias' ) );
		}
	}

}