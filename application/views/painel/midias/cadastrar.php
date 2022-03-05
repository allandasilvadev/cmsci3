<div class="row">
	<div class="col-lg-6">
		<?php 
		    echo form_open_multipart( base_url( 'painel/midias/inserir' ) );
		    	
		    	if ( ! empty( $errors ) ) {
		    		echo getMessages( $errors, 'info' );
		    	}
		        
		        echo '<div class="form-group">';
		            echo form_label( 'Mídia', 'uri', array( 'class' => 'ci-label' ) );
		            echo '<img src="'. base_url( 'assets/painel/images/no-image.jpg' ) .'" id="midias-uri">';
		            echo form_upload( 'uri', set_value( 'uri', FALSE ), array( 'class' => 'form-control', 'id' => 'uri' ) );
		            echo '<div class="midias-errors-messages"></div>';
		        echo '</div>';

		        echo '<div class="form-group">';
		            echo form_submit( 'cadastrar_midias', 'Cadastrar', array( 'class' => 'btn btn-success' ) );
		            echo anchor( base_url( 'painel/midias' ), 'Cancel', array( 'class' => 'btn btn-danger' ) );

		        echo '</div>';
		    echo form_close();
		?>
	</div>
</div>