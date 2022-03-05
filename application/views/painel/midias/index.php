<div class="row">
	<div class="col-lg-12">
		<p>

		    <a href="<?php echo base_url( 'painel/midias/create' ); ?>" class="btn btn-success">
		    	Cadastrar
		    </a>
		</p>		
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php 
		    if ( $this->session->flashdata( 'midias_messages' ) ) {
		    	if ( $this->session->flashdata( 'midias_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'midias_messages_type' );
		    	} else {
		    		$type = 'success';
		    	}

		    	echo getMessages( $this->session->flashdata( 'midias_messages' ), $type );
		    }
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="listar-midias">
			<thead>
				<tr>
					<th>Image</th>
					<th>Type</th>
					<th>Author</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $midias ) && sizeof( $midias ) > 0 ) {
				    	foreach ( $midias as $midia ) {
				    		?>
				    		<tr>
				    			<td id="midias-avatar">
				    				<?php 
				    				$midiauri = './uploads/midias/' . $midia['uri'];
				    				if ( file_exists( $midiauri ) && ! is_dir( $midiauri ) ) {
				    					echo '<img src="'. base_url( 'uploads/midias/' . $midia['uri'] ) .'" class="midias-uri-listar">';
				    				}
				    				?>
				    			</td>
				    			<td id="midias-type"><?php echo $midia['type']; ?></td>
				    			<td id="midias-author"><?php echo $this->usuarios->get_by( array( 'hash' => $midia['author'] ) )['nome']; ?></td>
				    			<td id="midias-acoes">
				    				<a href="<?php echo base_url( 'painel/midias/visualizar/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-warning">
				    					<i class="fa fa-fw fa-eye" aria-hidden="true"></i>
				    					Visualizar
				    				</a>

				    				<?php if ( is_admin() ) : ?>
				    				<a href="<?php echo base_url( 'painel/midias/editar/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-primary">
				    					<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
				    					Editar
				    				</a>
				    				<?php else : ?>
				    					<?php if ( $this->session->userdata('user')['hash'] === $midia['author'] ) : ?>
				    						<a href="<?php echo base_url( 'painel/midias/editar/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-primary">
						    					<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
						    					Editar
						    				</a>
				    					<?php endif ; ?>
				    				<?php endif ; ?>

				    				<?php if ( ! empty( $midia['deleted_at'] ) ) { ?>
				    					<?php if ( is_admin() ) : ?>
				    						<a href="<?php echo base_url( 'painel/midias/restaurar/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-warning">
					    						<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
					    						Restaurar
					    					</a>
				    					<?php else : ?>
				    						<?php if ( $this->session->userdata('user')['hash'] === $midia['author'] ) : ?>
				    							<a href="<?php echo base_url( 'painel/midias/restaurar/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-warning">
						    						<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
						    						Restaurar
						    					</a>
				    						<?php endif;?>
				    					<?php endif ; ?>
				    					
				    				<?php } else { ?>
				    					<?php if ( is_admin() ) : ?>
				    						<a href="<?php echo base_url( 'painel/midias/excluir/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-danger">
						    					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
						    					Excluir
						    				</a>
				    					<?php else : ?>
				    						<?php if ( $this->session->userdata('user')['hash'] === $midia['author'] ) : ?>
				    							<a href="<?php echo base_url( 'painel/midias/excluir/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-danger">
							    					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
							    					Excluir
							    				</a>
				    						<?php endif ;?>
				    					<?php endif ; ?>
				    					
				    				<?php } ?>
				    				
				    			</td>
				    		</tr>
				    		<?php
				    	}
				    } else {
				    	?>
				    	<tr>
				    		<td colspan="4">
				    			<p class="text-center no-results">
				    				Nenhuma mídia cadastrada.
				    			</p>
				    		</td>
				    	</tr>
				    	<?php
				    }
				?>
			</tbody>
		</table>
	</div>
</div>