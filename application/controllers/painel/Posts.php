<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Posts extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model( 'Posts_model', 'posts' );
		$this->load->model( 'Categorias_model', 'categorias' );
		$this->load->model( 'Posts_categorias_model', 'posts_categorias' );
		$this->data['posts'] = $this->posts->get_all();
		$this->data['categorias'] = $this->categorias->get_all();

		$this->_config['upload_path']      = './uploads/posts/';
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
		$this->render( 'painel/posts/index' );
	}

	public function cadastrar()
	{
		$this->data['method'] = 'cadastrar';
		$this->render( 'painel/posts/cadastrar' );
	}

	public function store()
	{
		if ( $this->input->post( 'cadastrar_posts', TRUE ) ) {
			$dados = array();

			$uploaded = TRUE;

			$this->form_validation->set_rules( 'title', 'Title', 'required|min_length[4]' );

			if ( $this->input->post( 'slug', TRUE ) ) {
				$this->form_validation->set_rules( 'slug', 'Slug', 'min_length[4]|is_unique[posts.slug]' );
			}

			$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[published,no-published]', array(
				'in_list' => 'O status informado não é válido.'
			) );

			$this->form_validation->set_rules( 'visibility', 'Visibilidade', 'required|in_list[public,private]', array(
				'in_list' => 'A visibilidade informada não é válida.'
			) );

			if ( $this->input->post( 'published_at', TRUE ) ) {
				$this->form_validation->set_rules( 'published_at', 'Published at', 'callback_published_at' );
			}

			if ( $this->input->post( 'expiration_at', TRUE ) ) {
				$this->form_validation->set_rules( 'expiration_at', 'Expiration at', 'callback_expiration_at' );
			}

			$this->form_validation->set_rules( 'body', 'Body', 'required|min_length[6]' );

			

			if ( $this->input->post( 'posts_categorias', TRUE ) ) 
			{
				// Convert array to string.
				$_POST['posts_categorias'] = implode( ',', $this->input->post( 'posts_categorias', TRUE ) );
				
				$this->form_validation->set_rules( 
					'posts_categorias', 
					'Categorias', 
					'callback_valid_categories' 
				);
			} else {
				$this->form_validation->set_rules( 'posts_categorias', 'Categorias', 'required' );
			}

			$success = $this->form_validation->run();

			if ( isset( $_FILES['avatar'] ) && ! empty( $_FILES['avatar']['tmp_name'] ) )
			{
				if ( ! $this->upload->do_upload( 'avatar' ) )
				{
					$this->session->set_flashdata( 'avatar_errors', $this->upload->display_errors() );
					$uploaded = FALSE;
					$dados['avatar'] = '';
				} else {
					$info = $this->upload->data();					
					$uploaded = TRUE;
					$dados['avatar'] = $info['file_name'];

					if ( ! $success ) 
					{
						unlink( './uploads/posts/' . $info['file_name'] );
					}				
				}
			} 
			else 
			{
				$dados['avatar'] = '';
			}

			if ( $success ) {
				$dados['title'] = strip_tags( addslashes( trim( $this->input->post( 'title', TRUE ) ) ) );
				$dados['slug'] = $this->slugify->slugify( $dados['title'] );
				$dados['title'] = htmlentities( $dados['title'] );
				$dados['status'] = $this->input->post( 'status', TRUE );
				$dados['visibility'] = $this->input->post( 'visibility', TRUE );
				$dados['author'] = $this->session->userdata('user')['hash'];
				$dados['body'] = $this->input->post( 'body', FALSE );
				$dados['hash'] = ci_rand(48);

				if ( $this->input->post( 'published_at', TRUE ) ) {
					$dados['published_at'] = date( 'Y-m-d H:i:s', strtotime( $this->input->post( 'published_at', TRUE ) ) );
				} else {
					$dados['published_at'] = NULL;
				}

				if ( $this->input->post( 'expiration_at', TRUE ) ) {
					$dados['expiration_at'] = date( 'Y-m-d H:i:s', strtotime( $this->input->post( 'expiration_at', TRUE ) ) );
				} else {
					$dados['expiration_at'] = NULL;
				}

				$dados['created_at'] = $this->now;

				if ( $uploaded === TRUE )
				{
					$inserir = $this->posts->insert( $dados );
					$post_id = $this->db->insert_id();

					if ( $this->input->post( 'posts_categorias' ) ) {
						$categorias_selecionadas = $this->input->post( 'posts_categorias' );
						$categorias_selecionadas = explode( ',', $categorias_selecionadas );

						foreach ( $categorias_selecionadas as $categoria_id ) 
						{
							$dados = array(
								'posts_id' => $post_id,
								'categorias_id' => $categoria_id
							);

							$this->posts_categorias->insert( $dados );
						} 
					}
				}
				

				if ( $inserir ) 
				{
					$this->session->set_flashdata( 'posts_messages', 'Post cadastrado com sucesso.' );
					$this->session->set_flashdata( 'posts_messages_type', 'success' );
					redirect( base_url( 'painel/posts' ) );
				}
				else 
				{
					$this->session->set_flashdata( 'posts_messages', 'Não foi possível cadastrar o post.' );
					$this->session->set_flashdata( 'posts_messages_type', 'danger' );
					redirect( base_url( 'painel/posts/cadastrar' ) );
				}

			} else {
				$this->cadastrar();
			}

		} else {
			redirect( base_url( 'painel/posts' ) );
		}
	}

	/* Validation Callbacks */
	public function published_at( $published_in = '' ) {
		if ( ! empty( $published_in ) ) {

			$post = date( 'Y-m-d', strtotime( $published_in ) );
			$now  = date( 'Y-m-d', strtotime( $this->now ) );

			if ( $post >= $now ) {
				return TRUE;
			} else {
				$this->form_validation->set_message( 'published_at', 'A data de publicação deve ser igual ou maior que a data atual.' );
				return FALSE;
			}

		} else {
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function expiration_at( $expiration_at = '' ) {
		if ( ! empty( $expiration_at ) ) {
 			$expiration_at = date( 'Y-m-d', strtotime( $expiration_at ) );
 			$now = date( 'Y-m-d', strtotime( $this->now ) );

 			if ( $this->input->post( 'published_at', TRUE ) ) {
 				$published_at = date( 'Y-m-d', strtotime( $this->input->post( 'published_at', TRUE ) ) );

 				if ( $expiration_at > $published_at ) {
 					return TRUE;
 				} else {
 					$this->form_validation->set_message( 'expiration_at', 'A data de expiração informada deve ser maior que a data de publicação.' );
 					return FALSE;
 				}
 			} else {
 				if ( $expiration_at > $now ) {
 					return TRUE;
 				} else {
 					$this->form_validation->set_message( 'expiration_at', 'A data de expiração informada deve ser maior que a data atual.' );
 					return FALSE;
 				}
 			}

		} else {
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function valid_categories( $categorias = '' ) 
	{
		$all_categories = $this->categorias->get_all();
		$id_categories  = array();
		
		foreach ( $all_categories as $category ) {
			array_push( $id_categories, $category['id'] );
		}

		// converte a string recebida em array.
		$categorias = explode( ',', $categorias );

		if ( is_array( $categorias ) && sizeof( $categorias ) > 0 ) 
		{
			$success = 0;

			foreach ( $categorias as $categoria ) {
				if ( in_array( $categoria, $id_categories ) ) {
					
				} else {					
					$success = $success + 1;
				}
			}

			
			if ( $success > 0 ) 
			{
				$this->form_validation->set_message( 'valid_categories', 'Categoria inválida.' );
				return FALSE;
			} 
			else 
			{
				return TRUE;
			}

		} 
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}	
	}

	public function excluir( $hash = '' ) 
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $post != null )
			{
				$this->data['method'] = 'excluir';
				$this->data['post']   = $post;
				$this->render( 'painel/posts/excluir' );
			}
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function send_trash( $hash = '' )
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash ) );

			if ( $post != null )
			{
				$postid = intval( $post['id'] );
				$update = $this->posts->update( $postid, array( 'deleted_at' => $this->now ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'posts_messages', 'Post movido para lixeira com sucesso.' );
					$this->session->set_flashdata( 'posts_messages_type', 'success' );
					redirect( base_url( 'painel/posts' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'posts_messages', 'Não foi possível mover o post para lixeira.' );
					$this->session->set_flashdata( 'posts_messages_type', 'danger' );
					redirect( base_url( 'painel/posts' ) );
				}	
			} 
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function restaurar( $hash = '' )
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash, 'deleted_at !=' => NULL ) );

			if ( $post != null )
			{
				$postid = intval( $post['id'] );
				$update = $this->posts->update( $postid, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'posts_messages', 'Post restaurado com sucesso.' );
					$this->session->set_flashdata( 'posts_messages_type', 'success' );
					redirect( base_url( 'painel/posts' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'posts_messages', 'Não foi possível restaurar o post.' );
					$this->session->set_flashdata( 'posts_messages_type', 'danger' );
					redirect( base_url( 'painel/posts' ) );
				}	
			} 
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function destroy( $hash = '' )
	{
		if ( ! empty( $hash ) )
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash ) );

			if ( $post != null )
			{
				$postid = intval( $post['id'] );
				$this->posts_categorias->deleteMany( array( 'posts_id' => $postid ) );

				if ( ! empty( $post['avatar'] ) ) {
					if ( file_exists( './uploads/posts/' . $post['avatar'] ) && ! is_dir( './uploads/posts/' . $post['avatar'] ) ) {
						unlink( './uploads/posts/' . $post['avatar'] );
					}
				}

				$delete = $this->posts->delete( $postid );

				if ( $this->db->affected_rows() > 0 )
				{
					$this->session->set_flashdata( 'posts_messages', 'Post excluído com sucesso.' );
					$this->session->set_flashdata( 'posts_messages_type', 'info' );
					redirect( base_url( 'painel/posts' ) );
				}
				else 
				{
					$this->session->set_flashdata( 'posts_messages', 'Não foi possível excluir o post.' );
					$this->session->set_flashdata( 'posts_messages_type', 'danger' );
					redirect( base_url( 'painel/posts' ) );
				}
			}
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function editar( $hash = '' )
	{
		if ( ! empty( $hash ) ) 
		{
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $post != null )
			{
				$this->data['method'] = 'editar';
				$this->data['post']   = $post;
				$this->render( 'painel/posts/editar' );
			}
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}

	public function update()
	{
		if ( $this->input->post( 'editar_posts', TRUE ) )
		{
			$hash = $this->input->post( 'posts_hash', TRUE );
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$post = $this->posts->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $post != null )
			{
				$dados = array();

				$uploaded = TRUE;

				$this->form_validation->set_rules( 'title', 'Title', 'required|min_length[4]' );

				if ( $this->input->post( 'slug', TRUE ) != $post['slug'] ) 
				{
					$this->form_validation->set_rules( 
						'slug', 
						'Slug', 
						'min_length[4]|is_unique[posts.slug]' 
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


				$this->form_validation->set_rules( 
					'status', 
					'Status', 
					'required|in_list[published,no-published]', 
					array(
						'in_list' => 'O status informado não é válido.'
					) 
				);

				$this->form_validation->set_rules( 
					'visibility', 
					'Visibilidade', 
					'required|in_list[public,private]', 
					array(
						'in_list' => 'A visibilidade informada não é válida.'
					) 
				);



				if ( $this->input->post( 'published_at', TRUE ) && $this->input->post( 'published_at', TRUE ) != $post['published_at'] ) 
				{
					$this->form_validation->set_rules( 
						'published_at', 
						'Published at', 
						'callback_published_at' 
					);
				}

				if ( $this->input->post( 'expiration_at', TRUE ) && $this->input->post( 'expiration_at', TRUE ) != $post['expiration_at'] ) 
				{
					$this->form_validation->set_rules( 
						'expiration_at', 
						'Expiration at', 
						'callback_expiration_at' 
					);
				}

				$this->form_validation->set_rules( 'body', 'Body', 'required|min_length[6]' );

				if ( $this->input->post( 'posts_categorias', TRUE ) ) 
				{
					// Convert array to string.
					$_POST['posts_categorias'] = implode( ',', $this->input->post( 'posts_categorias', TRUE ) );
				
					$this->form_validation->set_rules( 
						'posts_categorias', 
						'Categorias', 
						'callback_valid_categories' 
					);
				} 
				else 
				{
					$this->form_validation->set_rules( 'posts_categorias', 'Categorias', 'required' );
				}

				$success = $this->form_validation->run();

				if ( $success ) {

					if ( isset( $_FILES['avatar'] ) && ! empty( $_FILES['avatar']['tmp_name'] ) ) 
					{
						if ( ! $this->upload->do_upload( 'avatar' ) )
						{
							// error
							$this->session->set_flashdata( 'avatar_errors', $this->upload->display_errors() );
							$this->editar( $post['hash'] );
							
							$uploaded = FALSE;
							$dados['avatar'] = '';
						} 
						else 
						{
							// success
							$uploaded = TRUE;
							$info = $this->upload->data();

							// delete old avatar
							if ( ! empty( $post['avatar'] ) && file_exists( './uploads/posts/' . $post['avatar'] ) && ! is_dir( './uploads/posts/' . $post['avatar'] ) ) {
								unlink( './uploads/posts/' . $post['avatar'] );
							}

							$dados['avatar'] = $info['file_name'];							
						}
					} 
					else 
					{
						$dados['avatar'] = $post['avatar'];
					}
					

					$dados['title'] = html_entity_decode( $this->input->post( 'title', TRUE ) );
					$dados['title'] = strip_tags( addslashes( trim( $this->input->post( 'title', TRUE ) ) ) );

					if ( $this->input->post( 'slug', TRUE ) != $this->slugify->slugify( $dados['title'] ) ) {
						$dados['slug'] = html_entity_decode( $this->input->post( 'slug', TRUE ) );
						$dados['slug'] = strip_tags( addslashes( trim( $this->input->post( 'slug', TRUE ) ) ) );
						$dados['slug'] = $this->slugify->slugify( $dados['slug'] );
 					} else {
						$dados['slug'] = $this->slugify->slugify( $dados['title'] );	
					}
					
					$dados['title'] = htmlentities( $dados['title'] );
					$dados['status'] = $this->input->post( 'status', TRUE );
					$dados['visibility'] = $this->input->post( 'visibility', TRUE );
					$dados['body'] = $this->input->post( 'body', FALSE );

					if ( $this->input->post( 'published_at', TRUE ) ) 
					{
						$dados['published_at'] = date( 'Y-m-d H:i:s', strtotime( $this->input->post( 'published_at', TRUE ) ) );
					} 

					if ( $this->input->post( 'expiration_at', TRUE ) ) 
					{
						$dados['expiration_at'] = date( 'Y-m-d H:i:s', strtotime( $this->input->post( 'expiration_at', TRUE ) ) );
					} 

					$dados['updated_at'] = $this->now;

					$postid = intval( $post['id'] );

					if ( $uploaded === TRUE ) {
						$update = $this->posts->update( $postid, $dados );					

						if ( $this->input->post( 'posts_categorias' ) ) 
						{
							$categorias_selecionadas = $this->input->post( 'posts_categorias' );
							$categorias_selecionadas = explode( ',', $categorias_selecionadas );

							// delete old
							$this->posts_categorias->deleteMany( array( 'posts_id' => $postid ) );

							foreach ( $categorias_selecionadas as $categoria_id ) 
							{					

								// insert new
								$dados = array(
									'posts_id' => $postid,
									'categorias_id' => $categoria_id
								);
								
								$this->posts_categorias->insert( $dados );
							} 
						}
					}
					

					if ( $update )
					{
						$this->session->set_flashdata( 'posts_messages', 'Post editado com sucesso.' );
						$this->session->set_flashdata( 'posts_messages_type', 'info' );
						redirect( base_url( 'painel/posts' ) );
					}
					else 
					{
						$this->session->set_flashdata( 'posts_messages', 'Não foi possível editar o post.' );
						$this->session->set_flashdata( 'posts_messages_type', 'danger' );
						redirect( base_url( 'painel/posts' ) );
					}

				} else {
					$this->editar( $post['hash'] );
				}
			}
			else 
			{
				redirect( base_url( 'painel/posts' ) );
			}
		}
		else 
		{
			redirect( base_url( 'painel/posts' ) );
		}
	}
}