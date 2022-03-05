<div class="row">
	<div class="col-lg-6">
		<?php 
		    echo form_open_multipart( base_url( 'painel/paginas/store' ) );
		        echo '<div class="form-group">';
		            echo form_label( 'Title', 'title', array( 'class' => 'ci-label' ) );
		            echo form_input( 'title', set_value( 'title', NULL, FALSE ), array( 'class' => 'form-control' ) );
		            echo form_error( 'title', '<div class="errors-messages">', '</div>' );
		        echo '</div>';

		        echo '<div class="form-group">';
		            echo form_label( 'Slug', 'slug', array( 'class' => 'ci-label' ) );
		            echo form_input( 'slug', set_value( 'slug' ), array( 'class' => 'form-control' ) );
		            echo form_error( 'slug', '<div class="errors-messages">', '</div>' );
		        echo '</div>';

		        echo '<div class="form-group">';
		            echo form_label( 'Order', 'order', array( 'class' => 'ci-label' ) );
		            echo form_input( 'order', set_value( 'order' ), array( 'class' => 'form-control' ) );
		            echo form_error( 'order', '<div class="errors-messages">', '</div>' );
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
		        	echo form_label( 'Definir como página inicial ?', 'isHome', array( 'class' => 'ci-label' ) );
		        	echo '<div>';
		        	echo '<input type="checkbox" id="isHome" name="isHome" value="1"'. set_checkbox( 'isHome', '1', FALSE ) .'> Yes';
		        	echo form_error( 'isHome', '<div class="errors-messages">', '</div>' );
		        	echo '</div>';
		        echo '</div>';

		        echo '<div class="form-group">';
		            echo form_label( 'Body', 'body', array( 'class' => 'ci-label' ) );		            
		            echo '<p>' . anchor( '#', '<i class="fa fa-fw fa-picture-o" aria-hidden="true"></i> Galeria', array( 'class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#galeria-paginas' ) ) . '</p>';
		            echo form_textarea( 'body', set_value( 'body', NULL, FALSE ), array( 'class' => 'form-control', 'rows' => 12 ) );
		            echo form_error( 'body', '<div class="errors-messages">', '</div>' );
		        echo '</div>';

		        echo '<div class="form-group">';
		            echo '<button type="submit" name="paginas_cadastrar" id="paginas_cadastrar" class="btn btn-success pull-left" style="margin-right: 0.72%;" value="Cadastrar"><i class="fa fa-fw fa-check" aria-hidden="true"></i> Cadastrar</button>';
		            echo anchor( base_url( 'painel/paginas' ), '<i class="fa fa-fw fa-times" aria-hidden="true"></i> Cancelar', array( 'class' => 'btn btn-danger' ) );
		        echo '</div>';
		    echo form_close();

		    $uris = array(
		    	'painel/paginas/cadastrar',
		    	'painel/paginas/store'
		    );
		    if ( in_array( $this->uri->uri_string(), $uris ) ) {
		    	$this->load->view( 'painel/paginas/modal', $this->data );
		    }
		?>
	</div>
</div>