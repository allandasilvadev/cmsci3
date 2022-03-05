<div class="row">
	<div class="large-12 medium-12 columns">
		<div class="left">
			<h3><?php echo $title; ?></h3>
		    <p><?php echo $description; ?></p>
		</div>			

		<div class="right">
			<?php 
		        if ( is_array( $phones ) && sizeof( $phones ) > 0 ) {
		    	    foreach ( $phones as $phone ) {
		    		    echo sprintf( '<p>%s</p>', $phone['dados'] );
		    	    }
		        } else {
		    	    echo sprintf( '<em>Nenhum telefone cadastrado.</em>' );
		        }
		    ?>
		</div>			
	</div>
</div>


	<div class="contain-to-grid">
		<nav class="top-bar" data-topbar role="navigation">
  			<ul class="title-area">
    			<li class="name">
      				<h1>
      					<a href="<?php echo base_url(); ?>">
      						Inicial
      					</a>
      				</h1>
    			</li>     

    			<li class="toggle-topbar menu-icon">
    				<a href="<?php echo base_url(); ?>">
    					<span>Menu</span>
    				</a>
    			</li>
  			</ul>

  			<section class="top-bar-section">    		
    			
    			<ul class="right">
      				<li class="active">
      					<a href="<?php echo base_url( 'contatos' ); ?>">
      						Contatos
      					</a>
      				</li>     
    			</ul>
    
    			<ul class="left">
    				<?php 
    				    if ( is_array( $paginas ) && sizeof( $paginas ) > 0 ) {
    				    	foreach ( $paginas as $page ) {
    				    		$page_uri = base_url( 'paginas/' . strip_tags( addslashes( trim( $page['slug'] ) ) ) );

    				    		$slug = strip_tags( addslashes( trim( $page['slug'] ) ) );
    				    		if ( strtolower( $this->uri->segment(2) ) === $slug ) {
    				    			$class = 'class="active"';
    				    		} else {
    				    			$class = '';
    				    		}

    				    		echo sprintf( '<li %s><a href="%s">%s</a></li>', $class, $page_uri, $page['title'] );
    				    	}
    				    } else {

    				    }
    				?>
    			</ul>
  			</section>
		</nav>
	</div>