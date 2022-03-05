<!doctype html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title><?php echo $title; ?></title>

    	<?php 
    	    // Bootstrap Core CSS
    		echo load_css( 'assets/painel/css/bootstrap.min.css' );

    		echo load_css( 'assets/painel/css/style.min.css' );

    		// Custom CSS
    		echo load_css( 'assets/painel/css/sb-admin.css' );

    		// Custom Fonts
    		echo load_css( 'assets/painel/font-awesome/css/font-awesome.min.css' );

    		// JQuery Ui
    		echo load_css( 'assets/painel/css/jquery-ui.min.css' );

    		echo load_css( 'assets/painel/css/painel.css' );
    	?>

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
    	<div id="wrapper">
       		<?php  $this->load->view( 'painel/includes/navbar', $this->data ); ?>

        	<div id="page-wrapper">
            	<div class="container-fluid">
                	<div class="row">
                    	<div class="col-lg-12">
                        	<h1 class="page-header">
                        		<?php echo ucfirst( $this->router->fetch_class() ); ?>
                            	 <small><?php echo $method; ?></small>
                        	</h1>
                    	</div>
                	</div>

	            	<?php echo $container; ?>
            	</div>
        	</div>
    	</div>

    	<?php 
    		// JQuery 
    		// echo load_js( 'assets/painel/js/jquery.js' ); 
    		echo load_js( 'assets/painel/js/jquery-3.6.0.min.js' );

    		// Bootstrap Core JavaScript
    		echo load_js( 'assets/painel/js/bootstrap.min.js' );

    		// Autosize
    		echo load_js( 'assets/painel/js/autosize.min.js' );
    	?>

    	<script type="text/javascript">
    		jQuery(document).ready(function(){
				jQuery('.pesquisa').click(function(){
			    	let busca = jQuery( '#buscar_imagens' ).val();

			        jQuery.ajax({
			            type: "POST",
			        	url: "<?php echo base_url( 'painel/midias/get_midias' ); ?>",
			            data: {
			            	buscar_imagens: busca,
			            	<?php echo $this->security->get_csrf_token_name(); ?>: <?php echo '"' . $this->security->get_csrf_hash() . '"'; ?>
			            },
			            success: function( success ) {
			                jQuery( '.images' ).html( success );
			            },
			            error: function( err ) {
			            	console.log( err );
			            }
			        });
			    });
			});


			jQuery(document).ready(function(){
				let itens = jQuery('#sortable');
				let loading = jQuery('#loading');
				let header = jQuery('div h2');
				
				itens.sortable({
					update: function(event, ui){
						let uri = <?php echo '"' . base_url('painel/paginas/reorderpost') . '"'; ?>;
						let order = itens.sortable( 'toArray' );

						jQuery.ajax({
							method: "POST",
							url: uri,
							data: {
								_order: order
							},
							success: function(res){
								let Messages = `<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  									Reorder efetuada com sucesso.
								</div>`;

								jQuery('.header').html( Messages );

								console.log( res );
							}
						});
					}
				});
			});
    	</script>

    	<?php

    		// Tinymce
    		echo load_js( 'assets/painel/tinymce/tinymce.min.js' );

    		// JQuery UI
    		echo load_js( 'assets/painel/js/jquery-ui.min.js' );

    		// Custom JS
    		echo load_js( 'assets/painel/js/painel.js' );

    		$exception_editor_uris = array(
    			'painel/usuarios/cadastrar',
    			'painel/usuarios/store'
    		);

    		if ( ! in_array( strtolower( $this->uri->uri_string() ), $exception_editor_uris ) ) {
    			$current_class = strtolower( $this->router->fetch_class() );
    			$current_method = strtolower( $this->router->fetch_method() );

    			if ( $current_class === 'usuarios' && $current_method === 'editar' ) {

    			} else {
    				$current_uri = $this->uri->uri_string();
    				$no_editor_uris = array(
    					'painel/categorias/cadastrar',
    					'painel/categorias/inserir'
    				);

    				if ( in_array( $current_uri, $no_editor_uris ) ) {

    				} else {
    					if ( strtolower( $this->router->fetch_class() ) === 'categorias' && strtolower( $this->router->fetch_method() ) === 'editar' ) {

    					} else if ( strtolower( $this->router->fetch_class() ) === 'categorias' && strtolower( $this->router->fetch_method() ) === 'update' ) {

    					} else {
    						echo load_js( 'assets/painel/js/editor.js' );			
    					}
    					
    				}
    				
    			}
    			
    		}
    	?>
	</body>
</html>
