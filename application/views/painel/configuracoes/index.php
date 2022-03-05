<div class="row">
	<div class="col-lg-12">
		<p>
			<a href="<?php echo base_url( 'painel/configuracoes/cadastrar' ); ?>" class="btn btn-purple" style="border-radius: 0px !important;">
				Cadastrar
			</a>
		</p>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php 
		    if ( $this->session->flashdata( 'configuracoes_messages' ) ) {
		    	if ( $this->session->flashdata( 'configuracoes_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'configuracoes_messages_type' );
		    	} else {
		    		$type = 'success';
		    	}

		    	echo getMessages( $this->session->flashdata( 'configuracoes_messages' ), $type );
		    }
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="listar-configuracoes">
			<thead>
				<tr>
					<th>Guia</th>
					<th>Dados</th>
					<th>Status</th>
					<th>Author</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				    if ( is_array( $configuracoes ) && sizeof( $configuracoes ) > 0 ) {
				    	foreach ( $configuracoes as $configuracao ) {
				    		?>
				    		<tr>
				    			<td><?php echo $configuracao['guia']; ?></td>
				    			<td><?php echo $configuracao['dados']; ?></td>
				    			<td><?php echo $configuracao['status']; ?></td>
				    			<td><?php echo $this->usuarios->get_by( array( 'hash' => $configuracao['author'] ) )['nome']; ?></td>
				    			<td>
				    				<?php $configuracoes_hash = strip_tags( addslashes( trim( $configuracao['hash'] ))); ?>
				    				<a href="<?php echo base_url( 'painel/configuracoes/editar/' . $configuracoes_hash ); ?>" class="btn btn-info" style="border-radius: 0px !important;">
				    					<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
				    					Editar
				    				</a>


				    				<?php if (  empty( $configuracao['deleted_at'] ) ) : ?>
				    				<a href="<?php echo base_url( 'painel/configuracoes/excluir/' . $configuracoes_hash ); ?>" class="btn btn-danger" style="border-radius: 0px !important;">
				    					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				    					Excluir
				    				</a>
				    			    <?php else: ?>
				    			    	<a href="<?php echo base_url( 'painel/configuracoes/restaurar/' . $configuracoes_hash ); ?>" class="btn btn-warning" style="border-radius: 0px !important;">
				    					<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
				    					Restaurar
				    				</a>
				    			    <?php endif; ?>
				    			</td>
				    		</tr>
				    		<?php
				    	}
				    } else {
				    	?>
				    	<tr>
				    		<td colspan="5">
				    			<p class="text-center no-results">
				    				Nenhuma configuração cadastrada.
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