<?php 

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Codeigniter 3</title>
	</head>
	<body>
		<div class="container">
			<?php 
			    if ( is_array( $messages ) && sizeof( $messages ) > 0 ) {
			    		?>
			    		<table class="table table-striped table-bordered">
			    			<thead>
			    				<tr>
			    					<th>Author</th>
			    					<th>Label</th>
			    					<th>Body</th>
			    					<th>Created at</th>
			    				</tr>
			    			</thead>
			    			<tbody>
			    				<?php foreach ( $messages as $message ) { ?>
			    					<tr>
			    						<td><?php echo $message['author']; ?></td>
			    						<td><?php echo $message['label']; ?></td>
			    						<td><?php echo $message['body']; ?></td>
			    						<td><?php echo date( 'd-m-Y H:i:s', strtotime( $message['created_at'] ) ); ?></td>
			    					</tr>
			    				<?php } ?>
			    			</tbody>
			    		</table>
			    		<?php
			    } else {
			    	?>
			    	<p class="text-center">
			    		Nenhuma mensagem enviada.
			    	</p>
			    	<?php
			    }
			?>
		</div>
	</body>
</html>
