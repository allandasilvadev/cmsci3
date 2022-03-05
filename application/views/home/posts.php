<div class="container">
	<?php $this->load->view( 'includes/navbar', $this->data ); ?>

	<div class="row" style="margin-top: 2.8%;">
		<div class="large-8 columns">
			<h3><?php echo $post['title']; ?></h3>
			
			<p>
				<?php 
				    $page_author = $this->usuarios->get_by( array( 'hash' => $post['author'] ) );
				?>
				<span class="label-page">Author: </span> <?php echo $page_author['nome']; ?> | 
				<span class="label-page">Criada em: </span> <?php echo date( 'd-m-Y', strtotime( $post['created_at'] ) ); ?> 
				<?php if ( ! empty( $post['updated_at'] ) ) : ?>
					<?php echo sprintf( ' | <span class="label-page">Editada em:</span> %s', date( 'd-m-Y', strtotime( $post['updated_at'] ) ) ); ?>
				<?php endif ; ?>
			</p>

			<?php echo $post['body']; ?>
		</div>

		<div class="large-4 columns">
			<h4>Posts</h4>

			<?php 
			    if ( is_array( $posts ) && sizeof( $posts ) > 0 ) {
			    	echo sprintf( '<ul>' );
			    	foreach ( $posts as $post ) {
			    		$post_uri = base_url( 'posts/' . strip_tags( addslashes( trim( $post['slug'] ) ) ) );

			    		$slug = strip_tags( addslashes( trim( $post['slug'] ) ) );

    				    if ( strtolower( $this->uri->segment(2) ) === $slug ) {
    				    	$class = 'class="active"';
    				    } else {
    				    	$class = '';
    				    }

    				    if ( strtolower( $this->uri->segment(2) ) === $slug ) {
    				    	echo sprintf( '<li><em>%s</em></li>', $post['title'] );
    				    } else {
    				    	echo sprintf( '<li %s><a href="%s">%s</a></li>', $class, $post_uri, $post['title'] );
    				    }			    		
			    	}
			    	echo sprintf( '</ul>' );
			    } else {

			    }
			?>
		</div>
	</div>
</div>