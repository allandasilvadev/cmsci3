<div class="row">
	<div class="large-5 medium-5 large-centered medium-centered columns" id="painel-usuarios-login" style="background-color: #fef8e6;">
		<?php 
		    if ( $this->session->flashdata( 'recovery_errors_messages' ) ) {
		    	if ( $this->session->flashdata( 'recovery_errors_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'recovery_errors_messages_type' );
		    	} else {
		    		$type = 'success';
		    	}

		    	echo get_messages( $this->session->flashdata( 'recovery_errors_messages' ), $type );
		    }
		?>
		<?php 
			echo form_open( base_url( 'painel/usuarios/send_recovery_password' ) );	
			    echo form_label( 'Informe seu e-mail: ', 'recovery_password_mail', array( 'class' => 'ci-label' ) );	
			    echo form_input( 'recovery_password_mail', set_value( 'recovery_password_mail' ), array( 'style' => 'background-color: #fef8e6;' ) );
			    echo form_error( 'recovery_password_mail', '<div class="errors-messages">', '</div>' );

			    echo anchor( base_url( 'painel/usuarios/login'), 'Voltar a página de login', array( 'style' => 'font-size: 0.88em;font-style: italic;') );

				echo form_submit( 'recuperar', 'Recuperar', array( 'class' => 'button tiny primary right') );
				echo '<div class="clear"></div>';
			echo form_close(); 
		?>
	</div>
</div>