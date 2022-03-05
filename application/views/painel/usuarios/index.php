<div class="row">
	<div class="col-lg-12">
		<p>
			<a href="<?php echo base_url( 'painel/usuarios/cadastrar' ); ?>" class="btn btn-success" style="border-radius: 0px !important;">
				Cadastrar
			</a>
		</p>

		<?php 
		    if ( $this->session->flashdata( 'usuarios_messages' ) ) {
		    	if ( $this->session->flashdata( 'usuarios_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'usuarios_messages_type' );
 		    	} else {
		    		$type = 'success';
		    	}

		    	echo getMessages( $this->session->flashdata( 'usuarios_messages' ), $type );
		    }

		?>

		<table class="table table-striped table-bordered" id="listar-usuarios">
			<thead>
				<tr>
					<th>ID</th>
					<th>Avatar</th>
					<th>Nome</th>
					<th>Nível</th>
					<th>Status</th>
					<th id="acoes">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $users ) && sizeof( $users ) > 0 ) {
				    	foreach ( $users as $user ) {
				    		?>
				    		<tr>
				    			<td><?php echo $user['id']; ?></td>
				    			<td style="width: 26%;">
				    				<?php 
				    				    $usuarios_avatar_uri = './uploads/usuarios/avatars/' . $user['avatar'];

				    				    if ( file_exists( $usuarios_avatar_uri ) && ! is_dir( $usuarios_avatar_uri ) ) {
				    				    	echo sprintf( '<img src="%s" style="display: block; height: auto; width: auto; max-height: 120px; max-width: 120px;margin: 0 auto; padding: 2px; border: solid 1px #dedede; padding: 2px;">', base_url( 'uploads/usuarios/avatars/' . $user['avatar'] ) );
				    				    }
				    				?>				    					
				    			</td>
				    			<td><?php echo $user['nome']; ?></td>
				    			<td><?php echo get_nivel( $user['nivel'] ); ?></td>
				    			<td><?php echo get_status( $user['status'] ); ?></td>
				    			<td>
				    				<?php $user_hash = strip_tags( addslashes( trim( $user['hash'] ) ) ); ?>
				    				<a href="<?php echo base_url( 'painel/usuarios/editar/' . $user_hash ); ?>" class="btn btn-info" style="border-radius: 0px !important;margin-right: 1.2%;">
				    					<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
				    					Editar
				    				</a>

				    				<a href="<?php echo base_url( 'painel/usuarios/editar_senha/' . $user_hash ); ?>" class="btn btn-warning" style="border-radius: 0px !important; margin-right: 1.2%;">
				    					<i class="fa fa-fw fa-lock" aria-hidden="true"></i>
				    					Alterar senha
				    				</a>

				    				<?php if ( empty( $user['deleted_at'] ) ) { ?>
				    					<a href="<?php echo base_url( 'painel/usuarios/excluir/' . $user_hash ); ?>" class="btn btn-danger" style="border-radius: 0px !important; margin-right: 1.2%;">
					    					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
					    					Excluir
					    				</a>
				    				<?php } else { ?>
				    					<a href="<?php echo base_url( 'painel/usuarios/restaurar/'. $user_hash ); ?>" class="btn btn-success" style="border-radius: 0px !important; margin-right: 1.2%;">
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
				    		<td colspan="6">
				    			<p class="text-center no-results">
				    				Nenhum usuário cadastrado.
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