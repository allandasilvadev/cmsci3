<div class="row">
	<div class="col-lg-6">
		<?php echo form_open_multipart( base_url( 'painel/usuarios/update' ) ); ?>

		<div class="form-group">
			<label for="avatar" class="ci-label">Avatar</label>
			<?php 
			    if ( ! empty( $user['avatar'] ) ) {
			    	if ( file_exists( './uploads/usuarios/avatars/' . $user['avatar'] ) && ! is_dir( './uploads/usuarios/avatars/' . $user['avatar'] ) ) {
			    		$user_avatar_uri = base_url( 'uploads/usuarios/avatars/' . $user['avatar'] );
			    	} else {
			    		$user_avatar_uri = base_url( 'assets/painel/images/no-image.jpg' );
			    	}
			    } else {
			    	$user_avatar_uri = base_url( 'assets/painel/images/no-image.jpg' );
			    }
			?>
			<img src="<?php echo $user_avatar_uri; ?>" class="usuarios-avatar-src">
			<input type="file" name="avatar" id="usuarios-avatar" class="form-control">
			<?php 
			    if ( $this->session->flashdata( 'avatar_errors' ) ) {
			    	echo '<div class="errors-messages">' . $this->session->flashdata( 'avatar_errors' ) . '</div>';
			    }
			?>
		</div>

		<div class="form-group">
			<label for="nome" class="ci-label">Nome</label>
			<input type="text" name="nome" value="<?php echo set_value( 'nome', $user['nome'] ); ?>" class="form-control">
			<?php echo form_error( 'nome', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="login" class="ci-label">Login</label>
			<input type="text" name="login" value="<?php echo set_value( 'login', $user['login'] ); ?>" class="form-control">
			<?php echo form_error( 'login', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="email" class="ci-label">E-mail</label>
			<input type="text" name="email" value="<?php echo set_value( 'email', $user['email'] ); ?>" class="form-control">
			<?php echo form_error( 'email', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="nivel" class="ci-label">Nível</label>
			<select name="nivel" id="nivel" class="form-control">
				<option value="1" <?php echo set_select( 'nivel', '1', ( $user['nivel'] == '1' ) ? TRUE : FALSE ); ?>>Administrador</option>
				<option value="2" <?php echo set_select( 'nivel', '2', ( $user['nivel'] == '2' ) ? TRUE : FALSE ); ?>>Editor</option>
			</select>
			<?php echo form_error( 'nivel', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="status" class="ci-label">Status</label>
			<select name="status" id="status" class="form-control">
				<option value="0" <?php echo set_select( 'status', '0', ( $user['status'] == '0' ) ? TRUE : FALSE ); ?>>Inativo</option>
				<option value="1" <?php echo set_select( 'status', '1', ( $user['status'] == '1' ) ? TRUE : FALSE ); ?>>Ativo</option>
			</select>
			<?php echo form_error( 'status', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="sobre" class="ci-label">Sobre</label>
			<textarea name="sobre" id="sobre" rows="12" class="form-control"><?php echo set_value( 'sobre', $user['sobre'], FALSE ); ?></textarea>
			<?php echo form_error( 'sobre', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<input type="hidden" name="usuarios_hash" id="usuarios_hash" value="<?php echo strip_tags( addslashes( trim( $user['hash'] ) ) ); ?>">
			<button type="submit" name="editar_usuarios" id="editar_usuarios" class="btn btn-success" value="Editar" style="border-radius: 0px !important; margin-right: 1.2%;">
				<i class="fa fa-fw fa-check" aria-hidden="true"></i>
			    Editar
			</button>

			<a href="<?php echo base_url( 'painel/usuarios' ); ?>" class="btn btn-danger" style="border-radius: 0px !important; margin-right: 1.2%;">
				<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				Cancelar
			</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>