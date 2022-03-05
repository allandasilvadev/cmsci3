<div class="row">
	<div class="col-lg-6">
		<?php echo form_open( base_url( 'painel/configuracoes/store' ) ); ?>

		<div class="form-group">
			<label for="guia" class="ci-label">Guia predefinida: </label>
			<select name="guia" id="guia" class="form-control">
				<option value="phone"<?php echo set_select( 'guia', 'phone' ); ?>>Telefone</option>
				<option value="mail"<?php echo set_select( 'guia', 'mail' ); ?>>E-mail</option>
				<option value="address"<?php echo set_select( 'guia', 'address', TRUE ); ?>>Endereço</option>
			</select>
			<?php echo form_error( 'guia', '<div class="errors-messages">', '</div>' ); ?>
		</div>
		
		<div class="form-group">
			<label for="custom_guia" class="ci-label">Guia customizada: </label>
			<input type="text" name="custom_guia" id="custom_guia" class="form-control">
			<?php echo form_error( 'custom_guia', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="configuracao" class="ci-label">Dados: </label>
			<input type="text" name="configuracao" id="configuracao" value="<?php echo set_value( 'configuracao' ); ?>" class="form-control">
			<?php echo form_error( 'configuracao', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="status" class="ci-label">Status: </label>
			<select name="status" id="status" class="form-control">
				<option value="published"<?php echo set_select( 'status', 'published' ); ?>>Published</option>
				<option value="no-published"<?php echo set_select( 'status', 'no-published', TRUE ); ?>>No published</option>
			</select>
			<?php echo form_error( 'status', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<button type="submit" name="cadastrar_configuracoes" id="cadastrar_configuracoes" class="btn btn-success" value="Cadastrar">
				<i class="fa fa-fw fa-check" aria-hidden="true"></i>
				Cadastrar
			</button>

			<a href="<?php echo base_url( 'painel/configuracoes' ); ?>" class="btn btn-danger">
				<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				Cancelar
			</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>