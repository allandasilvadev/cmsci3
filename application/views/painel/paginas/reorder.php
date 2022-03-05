<div class="row">
	<div class="col-lg-6">
		
		<div class="header"></div>
		<ul id="sortable">
			<?php 
			    if ( is_array( $paginas ) && sizeof( $paginas ) > 0 ) {
			    	foreach ( $paginas as $pagina ) {
			    	    echo sprintf( '<li id="%u">%s</li>', intval( $pagina['id'] ), $pagina['title'] );
			    	}			    	

			    } else {

			    }
			?>
		</ul>
	</div>
</div>