<div class="row">
	<div class="col-lg-12">
		<?php 
		    echo get_notificacao( 'categorias_messages', 'categorias_messages_type' );
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<a href="<?php echo base_url( 'painel/categorias/cadastrar' ); ?>" class="btn btn-success">
			Cadastrar
		</a>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="categorias-listar">
			<thead>
				<tr>
					<th>Label</th>
					<th>Status</th>
					<th>Categoria pai</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $categorias ) && sizeof( $categorias ) > 0 ) {
				    	foreach ( $categorias as $category ) {
				    		?>
				    		<tr>
				    			<td><?php echo $category['label']; ?></td>
				    			<td><?php echo $category['status']; ?></td>
				    			<td>
				    				<?php 
				    				    if ( empty( $category['parent_category'] ) ) {
				    				    	echo 'Não possui categoria pai.';
				    				    } else {
				    				    	$parent = $this->categorias->get_by( array( 'hash' => $category['parent_category'] ) );
				    				    	echo $parent['label'];

				    				    }
				    				?>
				    			</td>
				    			<td>
				    				<?php 
				    					$categorias_hash = strip_tags( addslashes( trim( $category['hash'] ) ) ); 
				    					
				    					echo btn_edit( 
				    						base_url( 'painel/categorias/editar/' . $categorias_hash ) 
				    					);

				    					if ( ! empty( $category['deleted_at'] ) ) 
				    					{
				    						echo btn_restore(
				    							base_url( 'painel/categorias/restaurar/' . $categorias_hash )
				    						);
				    					} 
				    					else 
				    					{
				    						echo btn_delete(
				    							base_url( 'painel/categorias/deletar/' . $categorias_hash )
				    						);
				    					} 
				    				?>				    				
				    			</td>
				    		</tr>
				    		<?php
				    	}
				    } else {
				    	echo '<tr>';
				    	    echo '<td colspan="4"><p class="text-center no-results">Não há categorias cadastradas.</p></td>';
				    	echo '</tr>';

				    }
				?>
			</tbody>
		</table>
	</div>
</div>