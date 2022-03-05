<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				Você deseja excluir essa imagem ?
			</div>
			<div class="panel-body">
				<?php 
					$midiauri = './uploads/midias/' . $midia['uri'];

					if ( file_exists( $midiauri ) && ! is_dir( $midiauri ) ) {
						echo '<img src="'. base_url( 'uploads/midias/' . $midia['uri'] ) .'" class="visualizar-midias">';
					}
				?>

                <p class="text-center">
                	<a href="<?php echo base_url( 'painel/midias/destroy/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-danger">
                		<i class="fa fa-fw fa-times" aria-hidden="true"></i>
					        Excluir
				    </a>

				    <a href="<?php echo base_url( 'painel/midias/send_trash/' . strip_tags( addslashes( trim( $midia['hash'] ) ) ) ); ?>" class="btn btn-warning">
				    	<i class="fa fa-fw fa-trash" aria-hidden="true"></i>
					        Mover para lixeira
				    </a>

				    <a href="<?php echo base_url( 'painel/midias' ); ?>" class="btn btn-success">
				    	<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
					        Retornar
				    </a>
                </p>
				
			</div>
		</div>
	</div>
</div>