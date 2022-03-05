<div class="row">
	<div class="col-lg-6">
		<?php echo form_open_multipart( base_url( 'painel/usuarios/store' ) ); ?>

		<div class="form-group">
			<label for="avatar" class="ci-label">Avatar</label>
			<img src="<?php echo base_url( 'assets/painel/images/no-image.jpg' ); ?>" class="usuarios-avatar-src">
			<input type="file" name="avatar" id="usuarios-avatar" class="form-control">
			<?php 
			    if ( $this->session->flashdata( 'avatar_errors' ) ) {
			    	echo '<div class="errors-messages">' . $this->session->flashdata( 'avatar_errors' ) . '</div>';
			    }
			?>
		</div>

		<div class="form-group">
			<label for="nome" class="ci-label">Nome</label>
			<input type="text" name="nome" value="<?php echo set_value( 'nome' ); ?>" class="form-control">
			<?php echo form_error( 'nome', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="login" class="ci-label">Login</label>
			<input type="text" name="login" value="<?php echo set_value( 'login' ); ?>" class="form-control">
			<?php echo form_error( 'login', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="email" class="ci-label">E-mail</label>
			<input type="text" name="email" value="<?php echo set_value( 'email' ); ?>" class="form-control">
			<?php echo form_error( 'email', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="senha" class="ci-label">Senha</label>
			<input type="password" name="senha" id="senha" class="form-control" value="">
			<?php echo form_error( 'senha', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="senha_confirm" class="ci-label">Repita a senha</label>
			<input type="password" name="senha_confirm" id="senha_confirm" class="form-control" value="">
			<?php echo form_error( 'senha_confirm', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="nivel" class="ci-label">Nível</label>
			<select name="nivel" id="nivel" class="form-control">
				<option value="1" <?php echo set_select( 'nivel', '1' ); ?>>Administrador</option>
				<option value="2" <?php echo set_select( 'nivel', '2', TRUE ); ?>>Editor</option>
			</select>
			<?php echo form_error( 'nivel', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="status" class="ci-label">Status</label>
			<select name="status" id="status" class="form-control">
				<option value="0" <?php echo set_select( 'status', '0', TRUE ); ?>>Inativo</option>
				<option value="1" <?php echo set_select( 'status', '1' ); ?>>Ativo</option>
			</select>
			<?php echo form_error( 'status', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="sobre" class="ci-label">Sobre</label>
			<textarea name="sobre" id="sobre" rows="12" class="form-control"><?php echo set_value( 'sobre', NULL, FALSE ); ?></textarea>
			<?php echo form_error( 'sobre', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<button type="submit" name="cadastrar_usuarios" id="cadastrar_usuarios" class="btn btn-success" value="Cadastrar" style="border-radius: 0px !important; margin-right: 1.2%;">
				<i class="fa fa-fw fa-check" aria-hidden="true"></i>
			    Cadastrar
			</button>

			<a href="<?php echo base_url( 'painel/usuarios' ); ?>" class="btn btn-danger" style="border-radius: 0px !important; margin-right: 1.2%;">
				<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				Cancelar
			</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>