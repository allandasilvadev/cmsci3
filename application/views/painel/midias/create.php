<div class="row">
	<div class="col-lg-6">
		<?php 
		    echo form_open_multipart( base_url( 'painel/midias/store' ) );

		    echo '<div class="form-group">';
		    	echo form_label( 'Uri', 'uri', array( 'class' => 'ci-label' ) );
		    	echo '<img src="'. base_url( 'assets/painel/images/no-image.jpg' ) .'" id="midias-uri">';
		    	echo form_upload( 'uri', set_value( 'uri', FALSE ), array( 'class' => 'form-control', 'id' => 'uri' ) );
		    	if ( ! empty( $errors ) ) {
		    		echo '<div class="errors-messages">'. $errors .'</div>';
		    	}
		    echo '</div>';
		    
		    echo '<div class="form-group">';
		        echo form_label( 'Legenda', 'legenda', array( 'class' => 'ci-label' ) );
		        echo form_input( 'legenda', set_value( 'legenda' ), array( 'class' => 'form-control' ) );
		        echo form_error( 'legenda', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		    	echo form_label( 'Visibilidade', 'visibilidade', array( 'class' => 'ci-label' ) );
		    	echo '<select name="visibilidade" id="visibilidade" class="form-control">';
		    		echo '<option value="public"'. set_select( 'visibilidade', 'public' ) .'>Public</option>';
		    		echo '<option value="private"'. set_select( 'visibilidade', 'private', TRUE ) .'>Private</option>';
		    	echo '</select>';
		    	echo form_error( 'visibilidade', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    if ( is_admin() ) :
		    echo '<div class="form-group">';
		    	echo form_label( 'Status', 'status', array( 'class' => 'ci-label' ) );
		    	echo '<select name="status" id="status" class="form-control">';
		    		echo '<option value="published"'. set_select( 'status', 'published' ) .'>Published</option>';
		    		echo '<option value="no-published"'. set_select( 'status', 'no-published', TRUE ) .'>No published</option>';
		    	echo '</select>';
		    	echo form_error( 'status', '<div class="errors-messages">', '</div>' );
		    echo '</div>';
			endif;

		    echo '<div class="form-group">';
		    	echo form_label( 'Sobre a mídia', 'description', array( 'class' => 'ci-label' ) );
		    	echo form_textarea( 'description', set_value( 'description', FALSE ), array( 'class' => 'form-control' ) );
		    	echo form_error( 'description', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		        echo form_submit( 'cadastrar_categorias', 'Cadastrar', array( 'class' => 'btn btn-success', 'id' => 'cadastrar_categorias' ) );
		        echo anchor( base_url( 'painel/midias' ), 'Cancelar', array( 'class' => 'btn btn-danger' ) );
		    echo '</div>';
		    echo form_close();
		?>
	</div>
</div>