<div class="row">
	<div class="col-lg-8">
		<p>
			<a href="<?php echo base_url( 'painel/midias' ); ?>" class="btn btn-success">
				<i class="fa fa-fw fa-undo" aria-hidden="true"></i> Retornar
			</a>
		</p>
	</div>
</div>


<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-warning">
			<div class="panel-heading">
				Mídia
			</div>
			<div class="panel-body">
				<?php 
					$midiauri = './uploads/midias/' . $midia['uri'];

					if ( file_exists( $midiauri ) && ! is_dir( $midiauri ) ) {
						echo '<img src="'. base_url( 'uploads/midias/' . $midia['uri'] ) .'" class="visualizar-midias">';
					}
				?>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">
				Sobre a mídia
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tbody>
						<tr>
							<td>ID</td>
							<td><?php echo $midia['id']; ?></td>
						</tr>
						<tr>
							<td>Legenda</td>
							<td><?php echo $midia['legenda']; ?></td>
						</tr>
						<tr>
							<td>Visibilidade</td>
							<td><?php echo $midia['visibilidade']; ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php echo $midia['status']; ?></td>
						</tr>
						<tr>
							<td>Sobre a mídia</td>
							<td>
								<?php 
									if ( ! empty( $midia['description'] ) ) {
										echo $midia['description'];
									} else {
										echo '<em>Não há uma descrição para essa mídia.</em>';
									}
								?>									
							</td>
						</tr>
						<tr>
							<td>Cadastrada em</td>
							<td><?php echo date( 'd-m-Y H:i:s', strtotime( $midia['created_at'] ) ); ?></td>
						</tr>
						<tr>
							<td>Atualizada em</td>
							<td>
								<?php
									if ( ! empty( $midia['updated_at'] ) ) {
										echo date( 'd-m-Y H:i:s', strtotime( $midia['updated_at'] ) );
									} else {
										echo '<em>Essa mídia não foi editada.</em>';
									}
								?>									
							</td>
						</tr>
						<tr>
							<td>Movida para lixeira em</td>
							<td>
								<?php 
									if ( ! empty( $midia['deleted_at'] ) ) {
										echo date( 'd-m-Y H:i:s', strtotime( $midia['deleted_at'] ) );
									} else {
										echo '<em>Essa mídia não foi movida para lixeira.</em>';
									}
								?>									
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">
				Informações da mídia
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tbody>
						<tr>
							<td>Type</td>
							<td><?php echo $midia['type']; ?></td>
						</tr>
						<tr>
							<td>Extension</td>
							<td><?php echo $midia['extension']; ?></td>
						</tr>
						<tr>
							<td>Size</td>
							<td><?php echo round( ( $midia['size'] / 1024 ), 2 ); ?> MB</td>
						</tr>
						<tr>
							<td>Is image ?</td>
							<td>
								<?php  
								    if ( $midia['is_image'] === '1' ) {
								    	echo 'Yes';
								    } else {
								    	echo 'No';
								    }
								?>									
							</td>
						</tr>
						<tr>
							<td>Width</td>
							<td><?php echo $midia['image_width']; ?></td>
						</tr>
						<tr>
							<td>Height</td>
							<td><?php echo $midia['image_height']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>