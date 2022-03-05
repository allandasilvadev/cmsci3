<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-warning">
			<div class="panel-heading">
				Você deseja excluir o usuário <strong><?php echo $user['nome']; ?></strong>
			</div>
			<div class="panel-body">
				<a href="<?php echo base_url( 'painel/usuarios/destroy/' . strip_tags( addslashes( trim( $user['hash'] ) ) ) ); ?>" class="btn btn-danger" style="border-radius: 0px !important; margin-right: 1.2%;">
					<i class="fa fa-fw fa-times" aria-hidden="true"></i>
					Excluir
				</a>

				<a href="<?php echo base_url( 'painel/usuarios/send_trash/' . strip_tags( addslashes( trim( $user['hash'] ) ) ) ); ?>" class="btn btn-warning" style="border-radius: 0px !important; margin-right: 1.2%;">
					<i class="fa fa-fw fa-trash" aria-hidden="true"></i>
					Mover para lixeira
				</a>

				<a href="<?php echo base_url( 'painel/usuarios' ); ?>" class="btn btn-success" style="border-radius: 0px !important; margin-right: 1.2%;">
					<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
					Retornar
				</a>
			</div>
		</div>
	</div>
</div>