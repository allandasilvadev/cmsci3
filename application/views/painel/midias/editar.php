<div class="row">
	<div class="col-lg-6">
		<?php 
		    echo form_open_multipart( base_url( 'painel/midias/atualizar' ) );
		    echo '<div class="form-group">';
		    	echo form_label( 'Uri', 'uri', array( 'class' => 'ci-label' ) );
		    	
		    	if ( ! empty( $midia['uri'] ) ) {
		    		if ( file_exists( './uploads/midias/' . $midia['uri'] ) && ! is_dir( './uploads/midias/' . $midia['uri'] ) ) {
		    			$midiauri = base_url( 'uploads/midias/' . $midia['uri'] );
		    		} else {
		    			$midiauri = base_url( 'assets/painel/images/no-image.jpg' );
		    		}
		    	} else {
		    		$midiauri = base_url( 'assets/painel/images/no-image.jpg' );
		    	}
		    	echo '<img src="'. $midiauri .'" id="midias-uri">';

		    	echo form_upload( 'uri', set_value( 'uri' ), array( 'class' => 'form-control', 'id' => 'uri' ) );
		    	if ( ! empty( $errors ) ) {
		    		echo '<div class="errors-messages">'. $errors .'</div>';
		    	}
		    echo '</div>';
		    
		    echo '<div class="form-group">';
		        echo form_label( 'Legenda', 'legenda', array( 'class' => 'ci-label' ) );
		        echo form_input( 'legenda', set_value( 'legenda', html_entity_decode( $midia['legenda'] ) ), array( 'class' => 'form-control' ) );
		        echo form_error( 'legenda', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		    	echo form_label( 'Visibilidade', 'visibilidade', array( 'class' => 'ci-label' ) );
		    	echo '<select name="visibilidade" id="visibilidade" class="form-control">';
		    		echo '<option value="public"'. set_select( 'visibilidade', 'public', ( $midia['visibilidade'] === 'public' ) ? TRUE : FALSE ) .'>Public</option>';
		    		echo '<option value="private"'. set_select( 'visibilidade', 'private', ( $midia['visibilidade'] === 'private' ) ? TRUE : FALSE ) .'>Private</option>';
		    	echo '</select>';
		    	echo form_error( 'visibilidade', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    if ( is_admin() ) :
		    echo '<div class="form-group">';
		    	echo form_label( 'Status', 'status', array( 'class' => 'ci-label' ) );
		    	echo '<select name="status" id="status" class="form-control">';
		    		echo '<option value="published"'. set_select( 'status', 'published', ( $midia['status'] === 'published' ) ? TRUE : FALSE ) .'>Published</option>';
		    		echo '<option value="no-published"'. set_select( 'status', 'no-published', ( $midia['status'] === 'no-published' ) ? TRUE : FALSE ) .'>No published</option>';
		    	echo '</select>';
		    	echo form_error( 'status', '<div class="errors-messages">', '</div>' );
		    echo '</div>';
			endif;

		    echo '<div class="form-group">';
		    	echo form_label( 'Sobre a mídia', 'description', array( 'class' => 'ci-label' ) );
		    	echo form_textarea( 'description', set_value( 'description', html_entity_decode( $midia['description'] ), FALSE ), array( 'class' => 'form-control' ) );
		    	echo form_error( 'description', '<div class="errors-messages">', '</div>' );
		    echo '</div>';

		    echo '<div class="form-group">';
		    	echo form_hidden( 'midias_hash', strip_tags( addslashes( trim( $midia['hash'] ) ) ) );
		        echo form_submit( 'editar_midias', 'Editar', array( 'class' => 'btn btn-success', 'id' => 'editar_midias' ) );
		        echo anchor( base_url( 'painel/midias' ), 'Cancelar', array( 'class' => 'btn btn-danger' ) );
		    echo '</div>';
		    echo form_close();
		?>
	</div>
</div>