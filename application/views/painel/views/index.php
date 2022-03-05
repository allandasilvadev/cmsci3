<div class="row">
	<div class="col-lg-12">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Views</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				    if ( is_array( $views ) && sizeof( $views ) > 0 ) {
				    	foreach ( $views as $view ) {
				    		?>
				    		<tr>
				    			<td>
				    				<?php
				    					$icon = '';
				    				    
				    				    switch( $view['post_type'] ) {
				    				    	case 'page':
				    				    		$icon .= '<i class="fa fa-fw fa-file" aria-hidden="true"></i>&nbsp;';
				    				    	break;
				    				    	case 'post':
				    				    		$icon .= '<i class="fa fa-fw fa-bookmark" aria-hidden="true"></i>&nbsp;';
				    				    	break;
				    				    	default:
				    				    	break;
				    				    } 

				    				    echo $icon;
				    					echo ucfirst( $view['post_type'] ); ?>
				    			</td>
				    			<td>
				    				<?php 
				    				    switch( $view['post_type'] ) {
				    				    	case 'page':
				    				    	    $page = $this->paginas->get_by( array( 'hash' => $view['post_type_hash'] ) );
				    				    	    echo $page['title'];
				    				    	break;
				    				    	case 'post':
				    				    	    $post = $this->posts->get_by( array( 'hash' => $view['post_type_hash'] ) );
				    				    	    echo $post['title'];
				    				    	break;
				    				    	default:
				    				    	break;
				    				    }
				    				?>
				    			</td>
				    			<td><?php echo $view['views']; ?></td>
				    		</tr>
				    		<?php
				    	}
				    } else {

				    }
				?>
			</tbody>
		</table>
	</div>
</div>