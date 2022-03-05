<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="listar-auditoria">
			<thead>
				<tr>
					<th>ID</th>
					<th>Author</th>
					<th>Label</th>
					<th>Created at</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $auditoria ) && sizeof( $auditoria ) > 0 ) {
					    foreach ( $auditoria as $aud ) {
						?>
						<tr>
							<td><?php echo $aud['id']; ?></td>
							<td>
								<?php
								    $author = $this->usuarios->get_by( array( 'hash' => $aud['author'] ) );

								    if ( $author != null ) {
								    	echo $author['nome'];
								    } else {
								    	echo sprintf( '<em>Usuário não identificado.</em>' );
								    }
								?>
							</td>
							<td><?php echo $aud['label']; ?></td>
							<td>
								<?php 
								    echo date( 'd-m-Y H:i:s', strtotime( $aud['created_at'] ) );
								?>
							</td>
							<td>
								<a href="<?php echo base_url( 'painel/auditoria/visualizar/' . strip_tags( addslashes( trim( $aud['hash'] ) ) ) ); ?>" class="btn btn-primary" style="border-radius: 0px !important;">
									<i class="fa fa-fw fa-eye" aria-hidden="true"></i>
									Visualizar
								</a>
							</td>
						</tr>
						<?php
					    }
				    } 
				    else 
				    {
				    	?>
				    	<tr>
				    		<td colspan="6">
				    			<p class="text-center no-results">
				    				Nenhuma auditoria disponível.
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