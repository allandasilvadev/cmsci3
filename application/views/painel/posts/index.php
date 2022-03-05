<div class="row">
	<div class="col-lg-12">
		<p>
			<a href="<?php echo base_url( 'painel/posts/cadastrar' ); ?>" class="btn btn-purple" style="border-radius: 0px !important;">
				Cadastrar
			</a>
		</p>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php 
		    if ( $this->session->flashdata( 'posts_messages' ) ) {
		    	if ( $this->session->flashdata( 'posts_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'posts_messages_type' );
		    	} else {
		    		$type = 'success';
		    	}

		    	echo getMessages( $this->session->flashdata( 'posts_messages' ), $type );
		    }
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="listar-posts">
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Title</th>
					<th>Author</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $posts ) && sizeof( $posts ) > 0 ) {
				    	foreach( $posts as $post ) {
				    		?>
				    		<tr>
				    			<td>			    					
				    				<?php 
				    				    if ( ! empty( $post['avatar'] ) ) {
				    				    	$post_avatar_uri = './uploads/posts/' . $post['avatar'];

				    				    	if ( file_exists( $post_avatar_uri ) && ! is_dir( $post_avatar_uri ) ) {
				    				    		echo sprintf( '<img src="%s" style="display: block; height: auto; width: auto; max-height: 120px; max-width: 120px; padding: 2px; border: solid 1px #dedede;border-radius: 2px;margin: 0 auto;">', base_url( 'uploads/posts/' . $post['avatar'] ) );

				    				    	} else {
				    				    		echo '<em>Imagem não encontrada.</em>';
				    				    	}

				    				    } else {
				    				    	echo '<em>Nenhuma imagem selecionada.</em>';
				    				    }
				    				?>
				    			</td>
				    			<td><?php echo $post['title']; ?></td>
				    			<td><?php echo $this->usuarios->get_by( array( 'hash' => $post['author'] ) )['nome']; ?></td>
				    			<td>
				    				<?php 
				    				    $post_hash = strip_tags( addslashes( trim( $post['hash'] ) ) ); 
				    				?>
				    				<a href="<?php echo base_url( 'painel/posts/editar/' . $post_hash ); ?>" class="btn btn-info">
				    					<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
				    					Editar
				    				</a>

				    				<?php if ( empty( $post['deleted_at'] ) ) { ?>
				    					<a href="<?php echo base_url( 'painel/posts/excluir/' . $post_hash ); ?>" class="btn btn-danger">
					    					<i class="fa fa-fw fa-trash" aria-hidden="true"></i>
					    					Excluir
					    				</a>
				    				<?php } else { ?>
				    					<a href="<?php echo base_url( 'painel/posts/restaurar/' . $post_hash ); ?>" class="btn btn-warning">
				    						<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
				    						Restaurar
				    					</a>
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
				    				Nenhum post cadastrado.
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