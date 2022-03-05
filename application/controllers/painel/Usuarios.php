<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Usuarios extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();

		$config = array();
		$config['upload_path']      = './uploads/usuarios/avatars/';
		$config['file_ext_tolower'] = TRUE;
		$config['allowed_types']    = 'jpg|png';
		$config['overwrite']        = FALSE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = 2048;
		$config['max_width']        = 1920;
		$config['max_height']       = 1080;

		$this->load->library( 'upload', $config );
	}

	public function index()
	{
		$this->data['method'] = 'início';
		$this->render( 'painel/usuarios/index' );
	}

	public function cadastrar() {
		$this->data['method'] = 'cadastrar';
		$this->render( 'painel/usuarios/cadastrar' );
	}

	public function store() {
		if ( $this->input->post( 'cadastrar_usuarios', TRUE ) ) {
			$dados = array();

			$this->form_validation->set_rules( 'nome', 'Nome', 'required|min_length[4]' );
			$this->form_validation->set_rules( 'login', 'Login', 'required|min_length[4]|is_unique[usuarios.login]');
			$this->form_validation->set_rules( 'email', 'E-mail', 'required|valid_email|is_unique[usuarios.email]');
			$this->form_validation->set_rules( 'senha', 'Senha', 'required|min_length[6]|matches[senha_confirm]');
			$this->form_validation->set_rules( 'senha_confirm', 'Repita a senha', 'required|min_length[6]|matches[senha]');
			$this->form_validation->set_rules( 'nivel', 'Nível', 'required|in_list[1,2]', array(
				'in_list' => 'O nível informado não é válido.'
			));
			$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[0,1]', array(
				'in_list' => 'O status informado não é válido.'
			));

			if ( $this->input->post( 'sobre', TRUE ) ) {
				$this->form_validation->set_rules( 'sobre', 'Sobre', 'min_length[6]' );
			}

			$success = $this->form_validation->run();
			$uploaded = TRUE;

			if ( $success ) {

				if ( isset( $_FILES['avatar'] ) && ! empty( $_FILES['avatar']['tmp_name'] ) ) {
					if ( ! $this->upload->do_upload( 'avatar' ) ) {
						// error
						$uploaded = FALSE;
						$this->session->set_flashdata( 'avatar_errors', $this->upload->display_errors() );
					} else {
						// success
						$info = $this->upload->data();

						$uploaded = TRUE;
						$dados['avatar'] = $info['file_name'];
					}
				} else {
					$uploaded = TRUE;
					$dados['avatar'] = '';
				}

				if ( $uploaded === TRUE ) {

					$dados['nome'] = strip_tags( addslashes( trim( $this->input->post( 'nome', TRUE ) ) ) );
					$dados['nome'] = htmlentities( $dados['nome'] );
					$dados['login'] = strip_tags( addslashes( trim( $this->input->post( 'login', TRUE ) ) ) );
					$dados['email'] = $this->input->post( 'email', TRUE );
					$dados['nivel'] = $this->input->post( 'nivel', TRUE );
					$dados['status'] = $this->input->post( 'status', TRUE );
					$dados['senha'] = sha1( config_item( 'app_key' ) . $this->input->post( 'senha', TRUE ) );

					if ( $this->input->post( 'sobre', FALSE ) ) {
						$dados['sobre'] = $this->input->post( 'sobre', FALSE );
						$dados['sobre'] = strip_tags( addslashes( trim( $dados['sobre'] ) ), '<p><strong>' );
					} else {
						$dados['sobre'] = '';
					}

					$dados['hash'] = ci_rand(48);
					$dados['created_at'] = $this->now;

					$inserir = $this->usuarios->insert( $dados );

					if ( $inserir ) {
						$this->session->set_flashdata( 'usuarios_messages', 'Usuário cadastrado com sucesso.' );
						$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
						redirect( base_url( 'painel/usuarios' ) );
					} else {
						$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível cadastrar o usuário.' );
						$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
						redirect( base_url( 'painel/usuarios' ) );
					}

				} else {
					$this->cadastrar();
				}

			} else {
				$this->cadastrar();
			}

		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function editar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash ) );

			if ( $user != null ) {
				$this->data['method'] = 'editar';
				$this->data['user'] = $user;
				$this->render( 'painel/usuarios/editar' );

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function update() {
		if ( $this->input->post( 'editar_usuarios', TRUE ) ) {
			$userHash = strip_tags( addslashes( trim( $this->input->post( 'usuarios_hash', TRUE ) ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $userHash ) );

			if ( $user != null ) {

				$dados = array();

				$uploaded = TRUE;

				$this->form_validation->set_rules( 'nome', 'Nome', 'required|min_length[4]' );

				if ( $this->input->post( 'login', TRUE ) != $user['login'] ) {
					$this->form_validation->set_rules( 'login', 'Login', 'required|min_length[4]|is_unique[usuarios.login]');
				}

				if ( $this->input->post( 'email', TRUE ) != $user['email'] ) {
					$this->form_validation->set_rules( 'email', 'E-mail', 'required|valid_email|is_unique[usuarios.email]');
				}

				$this->form_validation->set_rules( 'nivel', 'Nível', 'required|in_list[1,2]', array(
					'in_list' => 'O nível informado não é válido.'
				));

				$this->form_validation->set_rules( 'status', 'Status', 'required|in_list[0,1]', array(
					'in_list' => 'O status informado não é válido.'
				));

				if ( $this->input->post( 'sobre', TRUE ) ) {
					$this->form_validation->set_rules( 'sobre', 'Sobre', 'min_length[6]' );
				}

				$success = $this->form_validation->run();

				if ( $success ) {

					if ( isset( $_FILES['avatar'] ) && ! empty( $_FILES['avatar']['tmp_name'] ) ) {
						if ( ! $this->upload->do_upload( 'avatar' ) ) {
							// error
							$uploaded = FALSE;
							$this->session->set_flashdata( 'avatar_errors', $this->upload->display_errors() );
						} else {
							// delete old avatar.
							if ( file_exists( './uploads/usuarios/avatars/' . $user['avatar'] ) && is_file( './uploads/usuarios/avatars/' . $user['avatar'] ) ) {
								unlink( './uploads/usuarios/avatars/' . $user['avatar'] );
							}

							$info = $this->upload->data();
							$uploaded = TRUE;
							$dados['avatar'] = $info['file_name'];
						}
					} else {
						$uploaded = TRUE;
					}

					if ( $uploaded === TRUE ) {

						$dados['nome'] = strip_tags( addslashes( trim( $this->input->post( 'nome', TRUE ) ) ) );
						$dados['nome'] = htmlentities( $dados['nome'] );
						$dados['login'] = $this->input->post( 'login', TRUE );
						$dados['email'] = $this->input->post( 'email', TRUE );
						$dados['nivel'] = $this->input->post( 'nivel', TRUE );
						$dados['status'] = $this->input->post( 'status', TRUE );

						if ( $this->input->post( 'sobre', TRUE ) ) {
							$dados['sobre'] = strip_tags( addslashes( trim( $this->input->post( 'sobre', TRUE ) ) ) );
							$dados['sobre'] = htmlentities( $dados['sobre'] );
						}

						$dados['updated_at'] = $this->now;

						$user_id = intval( $user['id'] );
						$update = $this->usuarios->update( $user_id, $dados );

						if ( $update ) 
						{
							$this->session->set_flashdata( 'usuarios_messages', 'Usuário editado com sucesso.' );
							$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
							redirect( base_url( 'painel/usuarios' ) );
						} 
						else 
						{
							$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível editar o usuário.' );
							$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
							redirect( base_url( 'painel/usuarios' ) );
						}

					} else {
						$this->editar( $user['hash'] );
					}

				} else {
					$this->editar( $user['hash'] );
				}



			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function excluir( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $user != null ) {
				$this->data['method'] = 'excluir';
				$this->data['user'] = $user;
				$this->render( 'painel/usuarios/excluir' );

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function editar_senha( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash, 'deleted_at' => NULL ) );

			if ( $user != null ) {
				$this->data['method'] = 'editar senha';
				$this->data['user'] = $user;
				$this->render( 'painel/usuarios/editar_senha' );

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function update_password() {
		if ( $this->input->post( 'editar_senha_usuarios', TRUE ) ) {
			$userHash = strip_tags( addslashes( trim( $this->input->post( 'usuarios_hash', TRUE ) ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $userHash ) );

			if ( $user != null ) {
				$this->form_validation->set_rules( array(
					array(
						'field' => 'senha',
						'label' => 'Senha',
						'rules' => 'required|min_length[6]|matches[senha_confirm]'
					),
					array(
						'field' => 'senha_confirm',
						'label' => 'Repita a senha',
						'rules' => 'required|min_length[6]|matches[senha]'
					)
				) );

				$success = $this->form_validation->run();

				if ( $success ) {
					$dados = array();
					$dados['senha'] = sha1( config_item( 'app_key' ) . $this->input->post( 'senha', TRUE ) );
					$dados['updated_at'] = $this->now;

					$user_id = intval( $user['id'] );

					$updateSenha = $this->usuarios->update( $user_id, $dados );

					if ( $updateSenha ) {
						$this->session->set_flashdata( 
							'usuarios_messages', 
							'Senha editada com sucesso.' 
						);
						
						$this->session->set_flashdata( 
							'usuarios_messages_type', 
							'success' 
						);
						redirect( base_url( 'painel/usuarios' ) );
					} else {
						$this->session->set_flashdata( 
							'usuarios_messages', 
							'Não foi possível editar a senha.' 
						);
						
						$this->session->set_flashdata( 
							'usuarios_messages_type', 
							'danger' 
						);
						redirect( base_url( 'painel/usuarios' ) );
					}

				} else {
					$this->editar_senha( $user['hash'] );
				}

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function login()
	{
		$this->render( 'painel/usuarios/login', 'layouts/frontend' );
	}

	public function logar()
	{
		if ( $this->input->post( 'entrar', TRUE ) ) {

			$this->form_validation->set_rules( 'login', 'Login', 'required|min_length[4]' );
			$this->form_validation->set_rules( 'senha', 'Senha', 'required|min_length[4]' );

			$success = $this->form_validation->run();

			if ( $success ) {	
				$dados = array(
					'login' => $this->input->post( 'login', TRUE ),
					'senha' => sha1( config_item( 'app_key' ) . $this->input->post( 'senha', TRUE ) )
				);

				$logar = $this->usuarios->logar( $dados );

				if ( $logar ) {
					$logar['logged'] = TRUE;
					$logar['nivel']  = intval( $logar['nivel'] );

					$this->session->set_userdata( 'user', $logar );

					auditoria( 'Um usuário fez login no sistema.', 'O usuário <strong>'. $logar['nome'] .'</strong> fez login no sistema.' );
					
					redirect( base_url( 'painel/paginas' ) );
				} else {
					$this->session->unset_userdata( 'user' );
					$this->session->set_flashdata( 'usuarios_messages', 'Usuário e/ou senha inválidos.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'warning' );
					redirect( base_url( 'painel/usuarios/login' ) );
				}
			} else {
				$this->login();
			}

		} else {
			redirect( base_url( 'painel/usuarios/login' ) );
		}
	}

	public function sair() {
		auditoria( 
			'Um usuário fez logout no sistema.', 
			'O usuário <strong>'. $this->session->userdata('user')['nome'] .'</strong> fez logout no sistema.' 
		);
		
		$this->session->unset_userdata( 'user' );
		$this->session->set_flashdata( 'usuarios_messages', 'O usuário fez logout com sucesso.' );
		$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
		redirect( base_url( 'painel/usuarios/login' ) );
	}

	public function send_trash( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash ) );

			if ( $user != null ) {
				
				if ( $this->session->userdata( 'user' )['hash'] === $user['hash']  ) {
					$this->session->set_flashdata( 'usuarios_messages', 'Não é possível mover para lixeira um usuário logado.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}

				if ( intval( $user['id'] ) == '1' ) {
					$this->session->set_flashdata( 'usuarios_messages', 'Não é possível mover para lixeira o <strong>Super administrador</strong> do sistema.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}

				$user_id = intval( $user['id'] );
				$update = $this->usuarios->update( $user_id, array( 'deleted_at' => $this->now ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'usuarios_messages', 'Usuário movido para lixeira com sucesso.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
					redirect( base_url( 'painel/usuarios' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível mover o usuário para lixeira.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}	

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function restaurar( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash, 'deleted_at !=' => NULL ) );

			if ( $user != null ) {
				$user_id = intval( $user['id'] );
				$update = $this->usuarios->update( $user_id, array( 'deleted_at' => NULL ) );

				if ( $this->db->affected_rows() > 0 ) 
				{
					$this->session->set_flashdata( 'usuarios_messages', 'Usuário restaurado com sucesso.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
					redirect( base_url( 'painel/usuarios' ) );
				} 
				else 
				{
					$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível restaurar o usuário.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}	

			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function destroy( $hash = '' ) {
		if ( ! empty( $hash ) ) {
			$hash = strip_tags( addslashes( trim( $hash ) ) );
			$user = $this->usuarios->get_by( array( 'hash' => $hash ) );

			if ( $user != null ) {
				$user = $this->usuarios->get_by( array( 'hash' => $hash, 'id !=' => '1' ) );

				if ( $this->session->userdata( 'user' )['hash'] === $user['hash']  ) {
					$this->session->set_flashdata( 'usuarios_messages', 'Não é possível excluir um usuário logado.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}

				if ( $user != null ) {
					$user_id = intval( $user['id'] );

					if ( file_exists( './uploads/usuarios/avatars/' . $user['avatar'] ) && is_file( './uploads/usuarios/avatars/' . $user['avatar'] ) ) {
						unlink( './uploads/usuarios/avatars/' . $user['avatar'] );
					}

					$delete = $this->usuarios->delete( $user_id );
					
					if ( $delete ) 
					{
						$this->session->set_flashdata( 'usuarios_messages', 'Usuário deletado com sucesso.' );
						$this->session->set_flashdata( 'usuarios_messages_type', 'success' );
						redirect( base_url( 'painel/usuarios' ) );
					} 
					else 
					{
						$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível deletar o usuário.' );
						$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
						redirect( base_url( 'painel/usuarios' ) );
					}	

				} else {
					$this->session->set_flashdata( 'usuarios_messages', 'O usuário administrador não pode ser excluído.' );
					$this->session->set_flashdata( 'usuarios_messages_type', 'danger' );
					redirect( base_url( 'painel/usuarios' ) );
				}
			} else {
				redirect( base_url( 'painel/usuarios' ) );
			}
		} else {
			redirect( base_url( 'painel/usuarios' ) );
		}
	}

	public function recuperarSenha() {
		$this->render( 'painel/usuarios/recuperar_senha', 'layouts/frontend' );
	}

	public function send_recovery_password() {
		if ( $this->input->post( 'recuperar', TRUE ) ) {
			$this->form_validation->set_rules( 'recovery_password_mail', 'E-mail', 'required|valid_email' );

			$success = $this->form_validation->run();

			if ( $success ) {
				$mail = $this->input->post( 'recovery_password_mail', TRUE );
				$user = $this->usuarios->getOne( array( 'email' => $mail ) );

				if ( $user != null ) {

					$expiration_date_format = mktime(
						date('H'),
						date('i'),
						date('s'),
						date('m'),
						( date('d') + 1 ),
						date('Y')
					);

					$expiration_date = date( 'Y-m-d H:i:s', $expiration_date_format );
					$hash = ci_rand(68);

					/* delete expirated link from this address */
					$this->db->delete( 'passwords_recovery', array( 'address' => $mail ) );

					/* insert new link from this address */
					$this->db->insert( 'passwords_recovery', array(
						'address' => $mail,
						'hash'    => $hash,
						'expiration' => $expiration_date
					) );

					if ( $this->db->affected_rows() > 0 ) {
						$send = fopen( './mails/send.html', 'w+' );

						if ( $send ) {
							$dados = anchor( base_url( 'painel/usuarios/editarSenha/' . $hash . '/' . $mail . '/reiniciar' ), 'Recuperar' );

							if ( fwrite( $send, $dados ) ) {
								$this->session->set_flashdata( 'recovery_errors_messages', 'Um e-mail foi enviado com as instruções a serem seguidas para que você recupere sua senha.' );
								$this->session->set_flashdata( 'recovery_errors_messages_type', 'success' );
								redirect( base_url( 'painel/usuarios/recuperarSenha' ) );
							} else {
								$this->session->set_flashdata( 'recovery_errors_messages', 'Não foi possível enviar um e-mail para o endereço informado.' );
								$this->session->set_flashdata( 'recovery_errors_messages_type', 'alert' );
								redirect( base_url( 'painel/usuarios/recuperarSenha' ) );
							}

							fclose( $send );

						} else {

						}
					}

				} else {
					$this->session->set_flashdata( 'recovery_errors_messages', 'Nenhum usuário está registrado com esse endereço de e-mail.' );
					$this->session->set_flashdata( 'recovery_errors_messages_type', 'warning' );
					$this->recuperarSenha();
				}
			} else {
				$this->recuperarSenha();
			}
		} else {
			redirect( base_url( 'painel/usuarios/recuperarSenha' ) );
		}
	}

	public function editarSenha( $hash = '', $mail = '', $action = 'reiniciar' ) {
		if ( ! empty( $hash ) && ! empty( $mail ) && ! empty( $action ) && $action === 'reiniciar' ) {
			
			$hash = strip_tags( addslashes( trim( $this->uri->segments[4] ) ) );
			$mail = $this->uri->segments[5];
			$mail = filter_var( $mail, FILTER_SANITIZE_EMAIL );
			$mail = filter_var( $mail, FILTER_VALIDATE_EMAIL );
			$current = date( 'Y-m-d H:i:s' );

			$this->db->where( array(
				'hash' => $hash,
				'address' => $mail,
				'expiration >=' => $current
			) );

			$this->db->limit(1);
			$query = $this->db->get( 'passwords_recovery' );
			$users = $query->row_array();

			if ( is_array( $users ) && sizeof( $users ) > 0 ) {
				$this->data['user_hash'] = $hash;
				$this->data['user_mail'] = $users['address'];
				$this->render( 'painel/usuarios/recovery_password', 'layouts/frontend' );

			} else {
				$this->render( 'painel/usuarios/recovery_error', 'layouts/frontend' );
			}

		} else {
			redirect( base_url( 'painel/usuarios/login' ) );
		}
	}

	public function recuperar_senha_post() {
		if ( $this->input->post( 'editar_senha', TRUE ) ) {

			if ( $this->input->post( 'user_action', TRUE ) && $this->input->post( 'user_action' ) === 'editar_senha_user' ) {
				if ( $this->input->post( 'user_hash', TRUE ) ) {
					
					$this->form_validation->set_rules( 
						'senha', 
						'Senha', 
						'required|min_length[4]|matches[senha_confirm]' 
					);

					$this->form_validation->set_rules( 
						'senha_confirm', 
						'Repita a senha', 
						'required|min_length[4]|matches[senha]'
					);

					$success = $this->form_validation->run();

					if ( $success ) {

						// validation success
						// update password user where
						$this->db->where( array(
							'hash' => $this->input->post( 'user_hash', TRUE )
						) );
						$this->db->limit(1);
						$query = $this->db->get( 'passwords_recovery' );
						$users = $query->row_array();

						if ( is_array( $users ) && sizeof( $users ) > 0 ) {
							// get user
							$user = $this->usuarios->getOne( array(
								'email' => $users['address']
							) );

							// update
							$id = intval( $user['id'] );

							$atualizar = $this->usuarios->update( $id, array(
								'senha' => sha1( config_item( 'app_key' ) . $this->input->post( 'senha', TRUE ) ),
								'updated_at' => $this->now
							) );

							if ( $this->db->affected_rows() > 0 ) {
								$this->session->set_flashdata( 'usuarios_messages', 'Senha alterada com sucesso.' );
								$this->session->set_flashdata( 'usuarios_messages_type', 'success' );

								// delete passwords recovery
								$this->db->where( array( 'hash' => $this->input->post( 'user_hash', TRUE ) ) );
								$this->db->delete( 'passwords_recovery' );

								redirect( base_url( 'painel/usuarios/login' ) );
							} else {
								$this->session->set_flashdata( 'usuarios_messages', 'Não foi possível editar a senha do usuário.' );
								$this->session->set_flashdata( 'usuarios_messages_type', 'alert' );
								redirect( base_url( 'painel/usuarios/login' ) );

							}
						} else {

						}

					} else {
						$hash = strip_tags( addslashes( trim( $this->input->post( 'user_hash', TRUE ) ) ) );
						$mail = strip_tags( addslashes( trim( $this->input->post( 'user_mail', TRUE ) ) ) );
						$this->data['user_hash'] = $hash;
						$this->data['user_mail'] = $mail;
						$this->render( 'painel/usuarios/recovery_password', 'layouts/frontend' );
					}
				}
			}		

		} else {
			redirect( base_url( 'painel/usuarios/login' ) );
		}
	}
}