<div class="row">
	<div class="large-5 medium-5 large-centered medium-centered columns" id="painel-usuarios-login">
		<?php 
			if ( $this->session->flashdata( 'usuarios_messages' ) ) {
				if ( $this->session->flashdata( 'usuarios_messages_type' ) ) {
					$type = $this->session->flashdata( 'usuarios_messages_type' );
				} else {
					$type = 'success';
				}

				echo get_messages( $this->session->flashdata( 'usuarios_messages' ), $type );
			}
			
		    echo form_open( base_url( 'painel/usuarios/logar' ) );
		    echo form_label( 'Login: ', 'login', array( 'class' => 'ci-label' ) );
		    echo form_input( 'login', set_value( 'login' ), array() );
		    echo form_error( 'login', '<div class="errors-messages">', '</div>' );
		    echo form_label( 'Senha: ', 'senha', array( 'class' => 'ci-label' ) );
		    echo form_password( 'senha', NULL, array() );
		    echo form_error( 'senha', '<div class="errors-messages">', '</div>' );

		    echo anchor( base_url( 'painel/usuarios/recuperarSenha'), 'Esqueci minha senha', array( 'style' => 'font-size: 0.94em;font-style: italic;') );
		    echo form_submit( 'entrar', 'Entrar', array( 'class' => 'button tiny success right' ) );
		    echo '<div class="clear"></div>';
		    echo form_close();
		?>
	</div>
</div>