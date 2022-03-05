<div class="modal fade" id="galeria-paginas" tabindex="-1" role="dialog" aria-labelledby="galeriapaginas">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        			<span aria-hidden="true">&times;</span>
        		</button>
        		
        		<h4 class="modal-title" id="galeriapaginas">Buscar imagens</h4>
      		</div>
      
      		<div class="modal-body">
      			<div class="row">
      				<div class="col-md-12">
      					<div class="form-group">
      						<?php 
		        			    echo form_label( 'Pesquisar', 'buscar_imagens', array( 'class' => 'ci-label' ) );
		        			    echo form_input( 'buscar_imagens', NULL, array( 'class' => 'form-control', 'id' => 'buscar_imagens' ) );
		        			?>
      					</div>
      				</div>
      			</div>

      			<div class="row">
      				<div class="col-md-12">
      					<div class="form-group">
      						<?php echo form_button( 'buscar', 'Pesquisar', array( 'class' => 'btn btn-success pesquisa') ); ?>
      					</div>
      				</div>
      			</div>

      			<div class="row">
      				<div class="col-md-12">
      					<div class="images"></div>
      				</div>
      			</div>
      		</div>

      		<div class="modal-footer">
        		<button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
      		</div>
    	</div>
  	s</div>
</div>