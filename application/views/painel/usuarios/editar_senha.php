<div class="row">
	<div class="col-lg-6">
		<?php echo form_open( base_url( 'painel/usuarios/update_password' ) ); ?>

		<p class="alert alert-info">
			Trocar senha do usuário <strong><?php echo $user['nome']; ?></strong> ?
		</p>


		<div class="form-group">
			<label for="senha" class="ci-label">Senha</label>
			<input type="password" name="senha" value="" class="form-control">
			<?php echo form_error( 'senha', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="senha_confirm" class="ci-label">Repita a senha</label>
			<input type="password" name="senha_confirm" value="" class="form-control">
			<?php echo form_error( 'senha_confirm', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<input type="hidden" name="usuarios_hash" id="usuarios_hash" value="<?php echo strip_tags( addslashes( trim( $user['hash'] ) ) ); ?>">
			<button type="submit" name="editar_senha_usuarios" id="editar_senha_usuarios" class="btn btn-success" value="Editar" style="border-radius: 0px !important; margin-right: 1.2%;">
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