<div class="row">
	<div class="col-lg-8">
		<?php echo form_open_multipart( base_url( 'painel/posts/store' ) ); ?>

		<div class="form-group">
			<label for="avatar" class="ci-label">Avatar: </label>
	        <img src="<?php echo base_url( 'assets/painel/images/no-image.jpg' ); ?>" id="midias-uri">
			<input type="file" id="avatar" name="avatar" value="" class="form-control">
			<?php
			    if ( $this->session->flashdata( 'avatar_errors' ) ) {
			    	echo '<div class="errors-messages">' . $this->session->flashdata('avatar_errors') . '</div>';
			    }
		    ?>
		</div>

		<div class="form-group">
			<label for="title" class="ci-label">Title: </label>
			<input type="text" name="title" value="<?php echo set_value( 'title' ); ?>" class="form-control">
			<?php echo form_error( 'title', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="slug" class="ci-label">Slug: </label>
			<input type="text" name="slug" value="<?php echo set_value( 'slug' ); ?>" class="form-control">
			<?php echo form_error( 'slug', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="status" class="ci-label">Status: </label>
			<select name="status" id="status" class="form-control">
				<option value="published"<?php echo set_select( 'status', 'published' ); ?>>Published</option>
				<option value="no-published"<?php echo set_select( 'status', 'no-published', TRUE ); ?>>No published</option>
			</select>
			<?php echo form_error( 'status', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="visibility" class="ci-label">Visibilidade: </label>
			<select name="visibility" id="visibility" class="form-control">
				<option value="public"<?php echo set_select( 'visibility', 'public' ); ?>>Public</option>
				<option value="private"<?php echo set_select( 'visibility', 'private', TRUE ); ?>>Private</option>
			</select>
			<?php echo form_error( 'visibility', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="published_at" class="ci-label">Published at <span class="optional">opcional</span></label>
			<?php echo getMessages( 'A data de publicação deve ser informada no formato <strong>DD-MM-YYYY</strong>', 'warning' ); ?>
			<input type="text" name="published_at" id="published_at" class="form-control" value="<?php echo set_value('published_at'); ?>">
			<?php echo form_error( 'published_at', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="expiration_at" class="ci-label">Expiration at <span class="optional">opcional</span></label>
			<?php echo getMessages( 'A data em que o post expira deve ser informada no formato <strong>DD-MM-YYYY</strong>', 'warning' ); ?>
			<input type="text" name="expiration_at" id="expiration_at" class="form-control" value="<?php echo set_value('expiration_at'); ?>">
			<?php echo form_error( 'expiration_at', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<label for="posts_categorias[]" class="ci-label">Categorias: </label>
			<?php 
			    if ( is_array( $categorias ) && sizeof( $categorias ) > 0 ) 
			    {			    	
			    	foreach ( $categorias as $category ) 
			    	{
			    		echo '<div class="posts_categorias_itens">';
                        echo '<input type="checkbox" name="posts_categorias[]" value="'. $category['id'] .'" ' . set_checkbox( 'posts_categorias[]', $category['id'] ) . '> ' . $category['label'];
                        echo '</div>';
			    	}
			    }

			    echo form_error( 'posts_categorias', '<div class="errors-messages">', '</div>' );
			?>
		</div>

		<div class="form-group">
			<label for="body" class="ci-label">Body: </label>
			<?php 
			    echo '<p>' . anchor( '#', '<i class="fa fa-fw fa-picture-o" aria-hidden="true"></i> Galeria', array( 'class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#galeria-posts' ) ) . '</p>';
			?>
			<textarea name="body" id="body" rows="12" class="form-control"><?php echo set_value( 'body', NULL, FALSE ); ?></textarea>
			<?php echo form_error( 'body', '<div class="errors-messages">', '</div>' ); ?>
		</div>

		<div class="form-group">
			<button type="submit" name="cadastrar_posts" id="cadastrar_posts" class="btn btn-success" style="margin-right: 0.8%;" value="Cadastrar">
				<i class="fa fa-fw fa-check" aria-hidden="true"></i>
				Cadastrar
			</button>

			<a href="<?php echo base_url( 'painel/posts' ); ?>" class="btn btn-danger">
				<i class="fa fa-fw fa-times" aria-hidden="true"></i>
				Cancelar
			</a>
		</div>
		<?php echo form_close(); ?>

		<?php 

		    $uris = array(
		    	'painel/posts/cadastrar',
		    	'painel/posts/store'
		    );

		    if ( in_array( $this->uri->uri_string(), $uris ) ) {
		    	$this->load->view( 'painel/posts/modal', $this->data );
		    }

		?>
	</div>
</div>