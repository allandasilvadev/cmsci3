<div class="row">
	<div class="col-lg-6">
		<?php echo form_open( base_url( 'painel/configuracoes/update' ) ); ?>

		<div class="form-group">
			<label for="guia" class="ci-label">Guia: </label>
			<select name="guia" id="guia" class="form-control">
				<option value="phone"<?php echo set_select( 'guia', 'phone', ( $configuracao['guia'] == 'phone' ) ? TRUE : FALSE ); ?>>Telefone</option>
				<option value="mail"<?php echo set_select( 'guia', 'mail', ( $configuracao['guia'] == 'mail' ) ? TRUE : FALSE ); ?>>E-mail</option>
				<option value="address"<?php echo set_select( 'guia', 'address', ( $configuracao['guia'] == 'address' ) ? TRUE : FALSE ); ?>>Endereço</option>
			</select>
			<?php echo form_error( 'guia', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<?php 
		    if ( in_array( $configuracao['guia'], array( 'phone', 'mail', 'address') ) ) {
		    	$value = '';
		    } else {
		    	$value = $configuracao['guia'];
		    }
		?>
		<div class="form-group">
			<label for="custom_guia" class="ci-label">Guia customizada: </label>
			<input type="text" name="custom_guia" id="custom_guia" class="form-control" value="<?php echo set_value( 'custom_guia', $value ); ?>">
			<?php echo form_error( 'custom_guia', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="configuracao" class="ci-label">Dados: </label>
			<input type="text" name="configuracao" id="configuracao" value="<?php echo set_value( 'configuracao', html_entity_decode( $configuracao['dados'] ) ); ?>" class="form-control">
			<?php echo form_error( 'configuracao', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="status" class="ci-label">Status: </label>
			<select name="status" id="status" class="form-control">
				<option value="published"<?php echo set_select( 'status', 'published', ( $configuracao['status'] == 'published' ) ? TRUE : FALSE ); ?>>Published</option>
				<option value="no-published"<?php echo set_select( 'status', 'no-published', ( $configuracao['status'] == 'no-published' ) ? TRUE : FALSE ); ?>>No published</option>
			</select>
			<?php echo form_error( 'status', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<input type="hidden" name="configuracoes_hash" id="configuracoes_hash" value="<?php echo strip_tags( addslashes( trim( $configuracao['hash'] ) ) ); ?>">

			<button type="submit" name="editar_configuracoes" id="editar_configuracoes" class="btn btn-success" value="Editar">
				<i class="fa fa-fw fa-check" aria-hidden="true"></i>
				Editar
			</button>

			<a href="<?php echo base_url( 'painel/configuracoes' ); ?>" class="btn btn-danger">
				<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				Cancelar
			</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>