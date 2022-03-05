<div class="row">
	<div class="large-5 medium-5 large-centered medium-centered columns" id="painel-usuarios-login" style="background-color: #fef8e6;">
		<?php 
		    echo form_open( base_url( 'painel/usuarios/recuperar_senha_post' ) );
		        echo form_label( 'Senha', 'senha', array( 'class' => 'ci-label' ) );
		        echo form_password( 'senha', NULL, array( 'style' => 'background-color: #fef8e6;' ) );
		        echo form_error( 'senha', '<div class="errors-messages">', '</div>' );

		        echo form_label( 'Repita a senha', 'senha_confirm', array( 'class' => 'ci-label' ) );
		        echo form_password( 'senha_confirm', NULL, array( 'style' => 'background-color: #fef8e6;' ) );
		        echo form_error( 'senha_confirm', '<div class="errors-messages">', '</div>' );

		        echo form_hidden( 'user_action', 'editar_senha_user' );
		        echo form_hidden( 'user_hash', strip_tags( addslashes( trim( $user_hash ) ) ) );
		        echo form_hidden( 'user_mail', strip_tags( addslashes( trim( $user_mail ) ) ) );
		        echo form_submit( 'editar_senha', 'Editar', array( 'class' => 'button tiny primary right' ) );
		        echo '<div class="clear"></div>';
		    echo form_close();
		?>
	</div>
</div>