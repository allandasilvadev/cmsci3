<div class="row">
	<div class="col-lg-6">
		
		<?php
		    echo form_open( base_url( 'painel/categorias/update' ) );

		        echo '<div class="form-group">';
		            echo form_label( 'Label', 'label', array( 'class' => 'ci-label' ) );
		            echo form_input( 'label', set_value( 'label', $categoria['label'] ), array( 'class' => 'form-control' ) );
		            echo form_error( 'label', '<div class="errors-messages">', '</div>' );
		        echo '</div>';

		        echo '<div class="form-group">';
		        	echo form_label( 'Slug', 'slug', array( 'class' => 'ci-label' ) );
		        	echo form_input( 'slug', set_value( 'slug', $categoria['slug'] ), array( 'class' => 'form-control' ) );
		        	echo form_error( 'slug', '<div class="errors-messages">', '</div>' );
		        echo '</div>';

		        if ( is_array( $categorias ) && sizeof( $categorias ) > 0 )	{
			    	echo '<div class="form-group">';
			    	echo form_label( 'Categoria pai', 'parent_category', array( 'class' => 'ci-label' ) );
			    	echo '<select name="parent_category" id="parent_category" class="form-control">';
			    	echo '<option value="">Selecione uma categoria</option>';
			    	foreach ( $categorias as $category ) {
			    		echo '<option value="'. $category['hash'] .'"'. set_select( 'parent_category', $category['hash'], ( $categoria['parent_category'] === $category['hash'] ) ? TRUE : FALSE ) .'>'. $category['label'] .'</option>';
			    	}
			    	echo '</select>';
			    	echo form_error( 'parent_category', '<div class="errors-messages">', '</div>' );
			    	echo '</div>';
			    } else {
			    	echo '<div class="clear" style="margin-top: 24px;"></div>';
			    	echo getMessages( 'Não há categorias cadastradas.', 'warning' );
			    }

		        echo '<div class="form-group">';
		        	echo form_label( 'Author ', 'author', array( 'class' => 'ci-label' ) );
		        	echo '<select name="author" id="author" class="form-control">';
		        	if ( is_array( $users ) && sizeof( $users ) > 0 ) {
		        		foreach ( $users as $user ) {
		        			echo '<option value="'. $user['hash'] . '"' . set_select( 'author', $user['hash'], ( $categoria['author'] === $user['hash'] ) ? TRUE : FALSE ) . '>'. $user['nome'] .'</option>';
		        		}
		        	}
		        	echo '</select>';
		        	echo form_error( 'author', '<div class="errors-messages">', '</div>' );
		    	echo '</div>';

		    	echo '<div class="form-group">';
		    		echo form_label( 'Status', 'status', array( 'class' => 'ci-label' ) );
		    		echo '<select name="status" id="status" class="form-control">';
		    			echo '<option value="published"'. set_select( 'status', 'published', ( $categoria['status'] === 'published' ) ? TRUE : FALSE ) .'>Published</option>';
		    			echo '<option value="no-published"'. set_select( 'status', 'no-published', ( $categoria['status'] === 'no-published' ) ? TRUE : FALSE ) .'>No published</option>';
		    		echo '</select>';
		    		echo form_error( 'status', '<div class="errors-messages">', '</div>' );
		    	echo '</div>';

		    	echo '<div class="form-group">';
			        echo form_label( 'Sobre a categoria ', 'description', array( 'class' => 'ci-label' ) );
			        echo form_textarea( 'description', set_value( 'description', $categoria['description'], FALSE ), array( 'class' => 'form-control', 'rows' => 8 ) );
			        echo form_error( 'description', '<div class="errors-messages">', '</div>' );
			    echo '</div>';

			    echo form_hidden( 'categorias_hash', strip_tags( addslashes( trim( $categoria['hash'] ) ) ) );

		        echo '<div class="form-group">';
		            echo '<button type="submit" name="editar_categorias" id="editar_categorias" value="Editar" class="btn btn-success pull-left" style="margin-right: 0.72%;"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i> Editar</button>';
		            echo anchor( base_url( 'painel/categorias' ), '<i class="fa fa-fw fa-times" aria-hidden="true"></i> Cancelar', array( 'class' => 'btn btn-danger' ) );
		        echo '</div>';
		    echo form_close();
		?>

	</div>
</div>