<div class="row">
	<div class="col-lg-6">
		<?php 
		    echo form_open( base_url( 'painel/categorias/inserir' ) );

		    echo '<div class="form-group">';
		        echo form_label( 'Categoria ', 'label', array( 'class' => 'ci-label' ) );
		        echo form_input( 'label', set_value( 'label' ), array( 'class' => 'form-control' ) );
		        echo get_errors_messages( 'label' );
		    echo '</div>';	

		    if ( is_array( $categorias ) && sizeof( $categorias ) > 0 )	{
		    	echo '<div class="form-group">';
		    	echo form_label( 'Categoria pai', 'parent_category', array( 'class' => 'ci-label' ) );
		    	echo '<select name="parent_category" id="parent_category" class="form-control">';
		    	echo '<option value="">Selecione uma categoria</option>';
		    	foreach ( $categorias as $category ) {
		    		echo '<option value="'. $category['hash'] .'">'. $category['label'] .'</option>';
		    	}
		    	echo '</select>';
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
		        		echo '<option value="'. $user['hash'] . set_select( 'author', $user['hash'] ) . '">'. $user['nome'] .'</option>';
		        	}
		        }
		        echo '</select>';
		        echo form_error( 'author', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		    	echo form_label( 'Status', 'status', array( 'class' => 'ci-label' ) );
		    	echo '<select name="status" id="status" class="form-control">';
		    		echo '<option value="published"'. set_select( 'status', 'published' ) .'>Published</option>';
		    		echo '<option value="no-published"'. set_select( 'status', 'no-published', TRUE ) .'>No published</option>';
		    	echo '</select>';
		    	echo form_error( 'status', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		        echo form_label( 'Sobre a categoria ', 'description', array( 'class' => 'ci-label' ) );
		        echo form_textarea( 'description', set_value( 'description' ), array( 'class' => 'form-control', 'rows' => 8 ) );
		        echo form_error( 'description', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		        echo form_submit( 'cadastrar_categorias', 'Cadastrar', array( 'class' => 'btn btn-success' ) );
		        echo anchor( base_url( 'painel/categorias' ), 'Cancelar', array( 'class' => 'btn btn-danger' ) );
		    echo '</div>';

		    echo form_close();
		?>
	</div>
</div>