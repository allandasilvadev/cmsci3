<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Midias extends Backend_Controller
{
	public $_config; 

	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Midias_model', 'midias' );
		$this->load->helper( array( 'language' ) );

		
		$this->_config['upload_path']      = './uploads/midias/';
		$this->_config['allowed_types']    = 'jpg|png|jpeg';
		$this->_config['file_ext_tolower'] = TRUE;
		$this->_config['overwrite']        = FALSE;
		$this->_config['max_size']         = 2048;
		// $this->_config['max_size']         = 10;
		$this->_config['max_width']        = (1280 * 2);
		$this->_config['max_height']       = (1080 * 2);
		$this->_config['encrypt_name']     = TRUE;

		$this->load->library( 'upload', $this->_config );
	}

	public function index()
	{
		$this->data['method'] = 'início';

		if ( is_admin() ) {
			$this->data['midias'] = $this->midias->get_all();
		} else {

			$midias_author = $this->midias->getMany( array( 'author' => $this->session->userdata('user')['hash'] ) );

			$published_midias = $this->midias->getMany( array( 'status' => 'published', 'author !=' => $this->session->userdata('user')['hash'], 'deleted_at' => NULL ) );

			$this->data['midias'] = array_merge( $midias_author, $published_midias );

		}
		
		$this->render( 'painel/midias/index' );
	}

	public function cadastrar()
	{
		$this->data['method'] = 'cadastrar';
		$this->data['errors'] = '';
		$this->render( 'painel/midias/cadastrar' );
	}

	public function create()
	{
		$this->data['method'] = 'create';
		
		if ( ! isset( $this->data['errors'] ) ) {
			$this->data['errors'] = '';	
		}
		
		$this->render( 'painel/midias/create' );
	}

	public function inserir()
	{
		if ( ! $this->upload->do_upload( 'uri' ) ) {
			$this->data['method'] = 'cadastrar';
			$this->data['errors'] = $this->upload->display_errors();
			$this->render( 'painel/midias/cadastrar' );
		} else {

			$info = $this->upload->data();

			$dados = array();
			$dados['hash'] = ci_rand(48);
			$dados['uri'] = $info['file_name'];
			$dados['type'] = $info['file_type'];
			$dados['author'] = $this->session->userdata('user')['hash'];
			$dados['extension'] = $info['image_type'];
			$dados['size'] = $info['file_size'];
			$dados['is_image'] = $info['is_image'];
			$dados['image_width'] = $info['image_width'];
			$dados['image_height'] = $info['image_height'];
			$dados['created_at'] = $this->now;

			$inserir = $this->midias->insert( $dados );

			if ( $this->db->affected_rows() > 0 ) {
				$this->session->set_flashdata( 'midias_messages', 'Mídia cadastrada com sucesso.' );
				$this->session->set_flashdata( 'midias_messages_type', 'success' );
				redirect( base_url( 'painel/midias' ) );
			} else {
				$this->session->set_flashdata( 'midias_messages', 'Não foi possível cadastrar a mídia.' );
				$this->session->set_flashdata( 'midias_messages_type', 'danger' );
				redirect( base_url( 'painel/midias' ) );
			}
		}
	}

	public function store()
	{
		if ( $this->input->post( 'cadastrar_categorias', TRUE ) ) {
			$dados = array();

			$this->form_validation->set_rules( 'legenda', 'Legenda', 'required|min_length[4]' );
			$this->form_validation->set_rules( 'visibilidade', 'Visibilidade', 'required|in_list[public,private]', array(
				'in_list' => 'O tipo de visibilidade informado não é válido.'
			) );

			if ( is_admin() ) 
			{
				$this->form_validation->set_rules( 
					'status', 
					'Status', 
					'required|in_list[published,no-published]', 
					array(
						'in_list' => 'O status informado não é válido.'
					) 
				);
			}
			

			if ( $this->input->post( 'description', TRUE ) ) {
				$this->form_validation->set_rules( 'description', 'Sobre a mídia', 'min_length[6]' );
			}

			$success = $this->form_validation->run();

			if ( $success ) {

				if ( ! $this->upload->do_upload( 'uri' ) ) {
					$this->data['errors'] = $this->upload->display_errors();
					$this->create();
				} else {
					$info = $this->upload->data();

					$dados['hash'] = ci_rand(48);
					$dados['uri'] = $info['file_name'];
					$dados['type'] = $info['file_type'];
					$dados['extension'] = $info['image_type'];
					$dados['size'] = $info['file_size'];
					$dados['is_image'] = $info['is_image'];
					$dados['image_width'] = $info['image_width'];
					$dados['image_height'] = $info['image_height'];
					$dados['created_at'] = $this->now;

					$dados['legenda'] = strip_tags( addslashes( trim( $this->input->post( 'legenda' ) ) ) );
					$dados['legenda'] = htmlentities( $dados['legenda'] );
					$dados['visibilidade'] = $this->input->post( 'visibilidade', TRUE );

					if ( is_admin() ) {
						$dados['status'] = $this->input->post( 'status', TRUE );
					} else {
						$dados['status'] = 'no-published';
					}
					

					if ( $this->input->post( 'description', TRUE ) ) {
						$dados['description'] = strip_tags( addslashes( trim( $this->input->post( 'description', TRUE ) ) ) );
						$dados['description'] = htmlentities( $dados['description'] );
					} else {
						$dados['description'] = '';
					}

					$dados['author'] = $this->session->userdata('user')['hash'];

					$inserir = $this->midias->insert( $dados );

					if ( $this->db->affected_rows() > 0 ) 
					{
						$this->session->set_flashdata( 'midias_messages', 'Mídia cadastrada com sucesso.' );
						$this->session->set_flashdata( 'midias_messages_type', 'success' );
						redirect( base_url( 'painel/midias' ) );
					} 
					else 
					{
						$this->session->set_flashdata( 'midias_messages', 'Não foi possível cadastrar a mídia.' );
						$this->session->set_flashdata( 'midias_messages_type', 'danger' );
						redirect( base_url( 'painel/midias' ) );
					}					
				}

			} else {
				if ( isset( $_FILES['uri' ] ) && ! empty( $_FILES['uri']['tmp_name'] ) ) {
					$filepath = $_FILES['uri']['tmp_name'];
					$fileSize = filesize( $filepath );
					$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
					$filetype = finfo_file( $fileinfo, $_FILES['uri']['tmp_name'] );

					$allowedTypes = [
					   'image/png' => 'png',
					   'image/jpeg' => 'jpg'
					];

					$filename = ci_rand(48); 
					$extension = $allowedTypes[ $filetype ];
					$targetDirectory = $this->_config['upload_path'];
					$newFilepath = $targetDirectory . $filename . "." . $extension;
				}				

				if ( ! isset( $_FILES['uri'] ) || empty( $_FILES['uri']['tmp_name'] ) ) {
					$this->data['errors'] = 'You did not select a file to upload.';
					$this->create();
				} else if ( ( filesize( $_FILES['uri']['tmp_name'] ) / 1024 ) > $this->_config['max_size'] ) {
					$this->data['errors'] = 'The file you are attempting to upload is larger than the permitted size.';
					$this->create();
				} else if ( ! in_array( $filetype, array_keys( $allowedTypes ) ) ) {
					$this->data['errors'] = 'The filetype you are attempting to upload is not allowed.';
					$this->create();
				} else if ( ! @copy( $filepath,  $newFilepath ) ) {
					unlink( $filepath );
					$this->data['errors'] = 'A problem was encountered while attempting to move the uploaded file to the final destination.';
					$this->create();
				} else {
					unlink( $newFilepath );					
					$this->create();
				}			
			}			
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function visualizar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$midia = $this->midias->get_by( array( 'hash' => $hash ) );

			if ( $midia != null ) {
				$this->data['method'] = 'visualizar';
				$this->data['midia'] = $midia;
				$this->render( 'painel/midias/visualizar' );
			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function excluir( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			if ( is_admin() ) {
				$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );
			} else {
				$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );
			}
			

			if ( $midia != null ) {
				$this->data['method'] = 'excluir';
				$this->data['midia'] = $midia;
				$this->render( 'painel/midias/excluir' );
			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function destroy( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			if ( is_admin() ) {
				$midia = $this->midias->get_by( array( 'hash' => $hash ) );	
			} else {
				$midia = $this->midias->get_by( array(
					'hash' => $hash,
					'author' => $this->session->userdata('user')['hash']
				) );
			}
			

			if ( $midia != null ) {
				$midiaid = intval( $midia['id'] );
				$midiauri = './uploads/midias/' . $midia['uri'];

				if ( file_exists( $midiauri ) && ! is_dir( $midiauri ) ) {
					unlink( $midiauri );
				}

				$this->midias->delete( $midiaid );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'midias_messages', 'Mídia excluída com sucesso.' );
					$this->session->set_flashdata( 'midias_messages_type', 'success' );
					redirect( base_url( 'painel/midias' ) );
				} else {
					$this->session->set_flashdata( 'midias_messages', 'Não foi possível excluir a mídia.' );
					$this->session->set_flashdata( 'midias_messages_type', 'danger' );
					redirect( base_url( 'painel/midias' ) );
				}

			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function send_trash( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );

			if ( is_admin() ) {
				$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );	
			} else {
				$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL, 'author' => $this->session->userdata('user')['hash'] ) );
			}
			

			if ( $midia != null ) {
				$midiaid = intval( $midia['id'] );

				$update = $this->midias->update( $midiaid, array( 'deleted_at' => $this->now ) );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'midias_messages', 'Mídia movida para lixeira com sucesso.' );
					$this->session->set_flashdata( 'midias_messages_type', 'success' );
					redirect( base_url( 'painel/midias' ) );
				} else {
					$this->session->set_flashdata( 'midias_messages', 'Não foi possível mover a mídia para lixeira.' );
					$this->session->set_flashdata( 'midias_messages_type', 'danger' );
					redirect( base_url( 'painel/midias' ) );
				}
			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function restaurar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );

			if ( is_admin() ) {
				$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at !=' => NULL ) );
			} else {
				$midia = $this->midias->get_by( array(
					'hash' => $hash,
					'deleted_at !=' => NULL,
					'author' => $this->session->userdata('user')['hash']
				) );
			}
			

			if ( $midia != null ) {
				$midiaid = intval( $midia['id'] );

				$update = $this->midias->update( $midiaid, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) {
					$this->session->set_flashdata( 'midias_messages', 'Mídia restaurada com sucesso.' );
					$this->session->set_flashdata( 'midias_messages_type', 'success' );
					redirect( base_url( 'painel/midias' ) );
				} else {
					$this->session->set_flashdata( 'midias_messages', 'Não foi possível restaurar a mídia.' );
					$this->session->set_flashdata( 'midias_messages_type', 'danger' );
					redirect( base_url( 'painel/midias' ) );
				}
			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function editar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			
			if ( is_admin() ) {
				$midia = $this->midias->get_by( array(
					'hash' => $hash,
					'deleted_at' => NULL
				 ) );
			} else {
				$midia = $this->midias->get_by( array( 
					'hash' => $hash, 
					'deleted_at' => NULL,
					'author' => $this->session->userdata('user')['hash']
				) );	
			}
			

			if ( $midia != null ) {
				$this->data['method'] = 'editar';
				$this->data['midia'] = $midia;
				$this->render( 'painel/midias/editar' );

			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function atualizar()
	{
		if ( $this->input->post( 'editar_midias', TRUE ) ) {
			$hash = $this->input->post( 'midias_hash', TRUE );
			$hash = strip_tags( addslashes( trim( $this->input->post( 'midias_hash', TRUE ) ) ) );
			$midia = $this->midias->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $midia != null ) {
				$dados = array();
				
				$this->form_validation->set_rules( 'legenda', 'Legenda', 'required|min_length[4]' );
				$this->form_validation->set_rules( 'visibilidade', 'Visibilidade', 'required|in_list[public,private]', array(
					'in_list' => 'O tipo de visibilidade informado não é válido.'
				) );
				$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array(
					'in_list' => 'O status informado não é válido.'
				) );

				if ( $this->input->post( 'description', TRUE ) ) {
					$this->form_validation->set_rules( 'description', 'Sobre a mídia', 'min_length[6]' );
				}

				$success = $this->form_validation->run();

				if ( $success ) {

					if ( isset( $_FILES['uri'] ) && ! empty( $_FILES['uri']['tmp_name'] ) ) {
						if ( ! $this->upload->do_upload( 'uri' ) ) {
							$this->data['errors'] = $this->upload->display_errors();
							$this->editar( $midia['hash'] );
						} else {
							$info = $this->upload->data();

							// delete old image
							$_midiauri = './uploads/midias/' . $midia['uri'];
							
							if ( file_exists( $_midiauri ) && ! is_dir( $_midiauri ) ) {
								unlink( $_midiauri );
							}

							/* dados */
							$dados['hash'] = ci_rand(48);
							$dados['uri'] = $info['file_name'];
							$dados['type'] = $info['file_type'];
							$dados['extension'] = $info['image_type'];
							$dados['size'] = $info['file_size'];
							$dados['is_image'] = $info['is_image'];
							$dados['image_width'] = $info['image_width'];
							$dados['image_height'] = $info['image_height'];						
							/* dados */
						}
					}					

					$dados['updated_at'] = $this->now;
					$dados['legenda'] = strip_tags(addslashes(trim($this->input->post( 'legenda' ))));
					$dados['legenda'] = htmlentities( $dados['legenda'] );
					$dados['visibilidade'] = $this->input->post( 'visibilidade', TRUE );
					$dados['status'] = $this->input->post( 'status', TRUE );

					if ( $this->input->post( 'description', TRUE ) ) 
					{
						$dados['description'] = strip_tags( addslashes( trim( $this->input->post( 'description', TRUE ) ) ) );
						$dados['description'] = htmlentities( $dados['description'] );
					} 
					else 
					{
						$dados['description'] = '';
					}


					$atualizar = $this->midias->update( intval( $midia['id'] ), $dados );

					if ( $this->db->affected_rows() > 0 ) 
					{
						$this->session->set_flashdata( 'midias_messages', 'Mídia editada com sucesso.' );
						$this->session->set_flashdata( 'midias_messages_type', 'info' );
						redirect( base_url( 'painel/midias' ) );
					} 
					else 
					{
						$this->session->set_flashdata( 'midias_messages', 'Não foi possível editar a mídia.' );
						$this->session->set_flashdata( 'midias_messages_type', 'danger' );
						redirect( base_url( 'painel/midias' ) );
					}		

				} else {
					if ( isset( $_FILES['uri'] ) && ! empty( $_FILES['uri']['tmp_name'] ) ) 
					{
						$filepath = $_FILES['uri']['tmp_name'];
						$fileSize = filesize( $filepath );
						$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
						$filetype = finfo_file( $fileinfo, $_FILES['uri']['tmp_name'] );

						$allowedTypes = [
						   'image/png' => 'png',
						   'image/jpeg' => 'jpg'
						];

						$filename = ci_rand(48); 
						$extension = $allowedTypes[ $filetype ];
						$targetDirectory = $this->_config['upload_path'];
						$newFilepath = $targetDirectory . $filename . "." . $extension;

						if ( ( $fileSize / 1024 ) > $this->_config['max_size'] ) 
						{
							$this->data['errors'] = 'The file you are attempting to upload is larger than the permitted size.';
							$this->editar( $midia['hash'] );
						} 
						else if ( ! in_array( $filetype, array_keys( $allowedTypes ) ) ) 
						{
							$this->data['errors'] = 'The filetype you are attempting to upload is not allowed.';
							$this->editar( $midia['hash'] );
						} 
						else if ( ! @copy( $filepath,  $newFilepath ) ) 
						{
							unlink( $filepath );
							$this->data['errors'] = 'A problem was encountered while attempting to move the uploaded file to the final destination.';
							$this->editar( $midia['hash'] );
						} 
						else {
							unlink( $newFilepath );					
							$this->editar( $midia['hash'] );
						}	
					} else {
						$this->editar( $midia['hash'] );	
					}					
				}

			} else {
				redirect( base_url( 'painel/midias' ) );
			}
		} else {
			redirect( base_url( 'painel/midias' ) );
		}
	}

	public function get_midias()
	{
		$arquivos = $this->input->post( 'buscar_imagens' );
		$getImage = $this->midias->pegar_images( $arquivos );
		$imagens  = '';

		if ( $getImage['total_rows'] > 0 ) {
			foreach ( $getImage['result'] as $img ) {
				$uri = base_url( 'uploads/midias/' . $img['uri'] );
				$legenda = $img['legenda'];

				// get all images
				$imagens .= '<a href="#" onclick="pegar_imagens(\''.$uri.'\', \''. $legenda .'\');return false;">';
				$imagens .= img( array(
					'src' => $uri,
					'style' => 'display:inline-block; margin: 8px 4px 8px 4px; max-height: 100px; max-width: 100px; width: auto; height: auto;border: solid 1px #dedede; padding: 2px; border-radius: 2px;'
				) );
				$imagens .= '</a>';
			}
		} else {
			$imagens .= 'Nenhuma imagem encontrada.';
		}

		echo $imagens;
	}
}