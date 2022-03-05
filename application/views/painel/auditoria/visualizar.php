<div class="row">
	<div class="col-lg-12">
		<p>
			<a href="<?php echo base_url( 'painel/auditoria' ); ?>" class="btn btn-success" style="border-radius: 0px !important">
			    <i class="fa fa-fw fa-undo" aria-hidden="true"></i>
			    Retornar
		    </a>
		</p>
		
		<div class="panel panel-success">
			<div class="panel-heading">
				Informações sobre essa ação
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead></thead>
					<tbody>
						<tr>
							<td>ID</td>
							<td><?php echo $aud['id']; ?></td>
						</tr>
						<tr>
							<td>Query sql executada</td>
							<td>
								<?php
								    $query = str_replace( "\'", "'", $aud['query'] );
								    echo SqlFormatter::format($query);
								?>
							</td>
						</tr>
						<tr>
							<td>Author</td>
							<td>
								<?php 
								    $author = $this->usuarios->get_by( array( 'hash' => $aud['author'] ) );

								    if ( $author != null ) {
								    	echo $author['nome'];
								    } else {
								    	echo '<em>Author desconhecido.</em>';
								    }
								?>
							</td>
						</tr>
						<tr>
							<td>Label</td>
							<td>
								<?php echo $aud['label']; ?>
							</td>
						</tr>
						<tr>
							<td>Description</td>
							<td>
								<?php
								    $description = str_replace( '&lt;strong&gt;', '<strong>', $aud['description'] );
								    $description = str_replace( '&lt;/strong&gt;', '</strong>', $description );
								    echo $description;
								?>	
							</td>
						</tr>
						<tr>
							<td>Realizada em</td>
							<td>
								<?php echo date( 'd-m-Y H:i:s', strtotime( $aud['created_at'] ) ); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>