<div class="row">
	<div class="col-lg-7">
		<div class="panel panel-danger">
			<div class="panel-heading">
				Você deseja excluir o <?php echo $config['guia']; ?> ?
			</div>
			<div class="panel-body">
				<p><?php echo $config['dados']; ?></p>

                <p>
                	<a href="<?php echo base_url( 'painel/configuracoes/destroy/' . strip_tags( addslashes( trim( $config['hash'] ) ) ) ); ?>" class="btn btn-danger" style="border-radius: 0px !important; margin-right: 1.2%;">
					    <i class="fa fa-fw fa-times" aria-hidden="true"></i>
					    Excluir
				    </a>

				    <a href="<?php echo base_url( 'painel/configuracoes/send_trash/' . strip_tags( addslashes( trim( $config['hash'] ) ) ) ); ?>" class="btn btn-warning" style="border-radius: 0px !important; margin-right: 1.2%;">
					    <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
					    Mover para a lixeira
				    </a>

				    <a href="<?php echo base_url( 'painel/configuracoes' ); ?>" class="btn btn-success" style="border-radius: 0px !important; margin-right: 1.2%;">
					    <i class="fa fa-fw fa-undo" aria-hidden="true"></i>
					    Retornar
				    </a>
                </p>
				
			</div>
		</div>
	</div>
</div>