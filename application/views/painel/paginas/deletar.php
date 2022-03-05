<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-warning">
			<div class="panel-heading">
				Você deseja excluir essa página ?
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>						
					</thead>
					<tbody>
						<tr>
							<td>Título</td>
							<td><?php echo $pagina['title']; ?></td>
						</tr>
						<tr>
							<td>Slug</td>
							<td><?php echo $pagina['slug']; ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php echo $pagina['status']; ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td><?php echo $this->usuarios->get_by( array( 'hash' => $pagina['author'] ) )['nome']; ?></td>
						</tr>
						<tr>
							<td>Página inicial ?</td>
							<td><?php echo ( $pagina['isHome'] == '1' ) ? 'Yes' : 'No';  ?></td>
						</tr>
						<tr>
							<td>Criada em</td>
							<td><?php echo date( 'd-m-Y H:i:s', strtotime( $pagina['created_at'] ) ); ?></td>
						</tr>
						<tr>
							<td>Editada em</td>
							<td>
								<?php 
								    if ( ! empty( $pagina['updated_at'] ) ) {
								    	echo date( 'd-m-Y H:i:s', strtotime( $pagina['updated_at'] ) );
								    } else {
								    	echo '<em>Essa página ainda não foi editada.</em>';
								    }
								?>
							</td>
						</tr>
					</tbody>
				</table>

				<a href="<?php echo base_url( 'painel/paginas/destroy/' . strip_tags( addslashes( trim( $pagina['hash'] ) ) ) ); ?>" class="btn btn-danger" style="margin-right: 1.2%;">
					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
					Excluir
				</a>

				<a href="<?php echo base_url( 'painel/paginas/send_trash/' . strip_tags( addslashes( trim( $pagina['hash'] ) ) ) ); ?>" class="btn btn-warning" style="margin-right: 1.2%;">
					<i class="fa fa-fw fa-trash" aria-hidden="true"></i>
					Mover para lixeira
				</a>

				<a href="<?php echo base_url( 'painel/paginas' ); ?>" class="btn btn-success" style="margin-right: 1.2%;">
					<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
					Retornar
				</a>

			</div>
		</div>
	</div>
</div>