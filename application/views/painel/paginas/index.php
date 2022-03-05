<div class="row">
	<div class="col-lg-12">
		<p>
			<a href="<?php echo base_url( 'painel/paginas/cadastrar' ); ?>" class="btn btn-success">
				Cadastrar
			</a>
		</p>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php 
		    if ( $this->session->flashdata( 'paginas_messages' ) ) {
		    	if ( $this->session->flashdata( 'paginas_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'categorias_messages_type' );
		    	} else {
		    		$type = 'success';
		    	}

		    	echo getMessages( $this->session->flashdata( 'paginas_messages' ), $type );
		    }
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php 

		    if ( $this->session->flashdata( 'categorias_messages' ) ) {
		    	if ( $this->session->flashdata( 'categorias_messages_type' ) ) {
		    		$type = $this->session->flashdata( 'categorias_messages_type' );
		    	} else {
		    		$type = 'info';
		    	}

		    	echo getMessages( $this->session->flashdata( 'categorias_messages' ), $type );
		    }

		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered" id="listar-paginas">
			<thead>
				<tr>
					<th>Title</th>
					<th>Status</th>
					<th>Author</th>
					<th>Página inicial</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $paginas ) && sizeof( $paginas ) > 0 ) {
				    	foreach ( $paginas as $pagina ) {
				    		echo '<tr>';
				    		    echo '<td>'. $pagina['title'] .'</td>';
				    		    echo '<td>'. $pagina['status'] .'</td>';
				    		    echo '<td>';
				    		        echo $this->usuarios->get_by( array( 'hash' => $pagina['author'] ) )['nome'];
				    		    echo '</td>';
				    		    echo '<td>';
				    		        echo ( $pagina['isHome'] === '1' ) ? 'Yes' : 'No';
				    		    echo '</td>';
				    		    echo '<td>';
				    		        $paginas_hash = strip_tags( addslashes( trim( $pagina['hash'] ) ) );

				    		        echo anchor( base_url( 'painel/paginas/editar/' . $paginas_hash ), '<i class="fa fa-fw fa-pencil" aria-hidden="true"></i> Editar', array( 'class' => 'btn btn-info', 'style' => 'margin-right: 2.4%;' ) );
				    		        
				    		        if ( empty( $pagina['deleted_at'] ) ) {

				    		        	echo anchor( base_url( 'painel/paginas/deletar/' . $paginas_hash ), '<i class="fa fa-fw fa-times" aria-hidden="true"></i> Excluir', array( 'class' => 'btn btn-danger' ) );

				    		        } else {

				    		        	echo anchor( base_url( 'painel/paginas/restaurar/' . $paginas_hash ), '<i class="fa fa-fw fa-undo" aria-hidden="true"></i> Restaurar', array( 'class' => 'btn btn-warning' ) );

				    		        }

				    		        
				    		    echo '</td>';
				    		echo '</tr>';
				    	}
				    } else {
				    	echo '<tr>';
				    	    echo '<td colspan="5">';
				    	        echo '<p class="text-center no-results">Nenhuma página cadastrada.</p>';
				    	    echo '</td>';
				    	echo '</tr>';
				    }
				?>
			</tbody>
		</table>
	</div>
</div>