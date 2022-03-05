<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Você deseja excluir a categoria <strong><?php echo $categoria['label']; ?></strong> ?
			</div>
			<div class="panel-body">
				<?php 
				    echo form_open( base_url( 'painel/categorias/excluir' ) );
				        echo '<div class="form-group">';
				            echo '<p>';
				            echo '<span class="ci-radio"><input type="radio" name="child_categories" value="deleted"></span>';
				            echo 'Excluir categorias filhas';
				            echo '</p>';

				            echo '<p>';
				            echo '<span class="ci-radio"><input type="radio" name="child_categories" value="updated" checked="checked"></span>';
				            echo 'Atualizar categorias filhas';
				            echo '</p>';
				        echo '</div>';

				        echo '<div class="form-group">';
				            echo form_hidden( 'categorias_hash', strip_tags( addslashes( trim( $categoria['hash'] ) ) ) );
				        echo '</div>'; 

				        echo '<div class="form-group">';
				        	echo btn_del( 'categorias_excluir', 'submit', 'Excluir permanentemente' );
				        echo '</div>';

				        echo '<div class="form-group">';
				        	echo btn_send_trash( 'submit', 'categorias_send_trash', 'Enviar para lixeira' );
				        echo '</div>';
				    echo form_close(); 
				?>
				<?php echo btn_cancel( base_url( 'painel/categorias' ) ); ?>
			</div>
		</div>
	</div>
</div>