<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $title; ?></title>
		<?php 
			echo load_css( 'assets/css/foundation.min.css' );
			echo load_css( 'assets/css/app.css' );
			
			$login_uris = array(
				'painel',
				'painel/usuarios/login',
				'painel/usuarios/logar',
				'painel/usuarios/recuperarSenha',
				'painel/usuarios/send_recovery_password',
				'painel/usuarios/recuperar_senha_post'
			);

			if ( in_array( $this->uri->uri_string(), $login_uris ) ) {
				echo load_css( 'assets/painel/css/login.css' );	
			} else if ( strtolower( $this->router->fetch_class() ) === 'usuarios' && strtolower( $this->router->fetch_method() ) == 'editarsenha' ) {
				echo load_css( 'assets/painel/css/login.css' );
			}
			
			echo load_js( 'assets/js/vendor/modernizr.js' );
		?>
	</head>
	<body>
		<?php echo $container; ?>

		<?php 
			echo load_js( 'assets/js/vendor/jquery.js' );
			echo load_js( 'assets/js/foundation.min.js' );

		?>
		<script type="text/javascript">
			$(document).foundation();
		</script>
	</body>
</html>