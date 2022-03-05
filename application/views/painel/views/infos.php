<div class="row">
	<div class="col-lg-8">
		<p>
			<a href="<?php echo base_url( 'painel/views' ); ?>" class="btn btn-success" style="border-radius: 0px !important;">
				<i class="fa fa-fw fa-undo" aria-hidden="true"></i>
				Retornar
			</a>
		</p>
		<div class="panel panel-warning">
			<div class="panel-heading">
				Informações sobre navegadores
			</div>
			<div class="panel-body">
				<?php
				    $chrome = $this->infos->getMany( array( 'navigator' => 'Chrome' ) );
				    $firefox = $this->infos->getMany( array( 'navigator' => 'Firefox' ) );

				    echo sprintf( '<p>Chrome: %u</p>', sizeof( $chrome ) );
				    echo sprintf( '<p>Firefox: %u</p>', sizeof( $firefox ) );
				?>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">
				Informações sobre sistemas operacionais
			</div>
			<div class="panel-body">
				<?php 
				    $linux = $this->infos->getMany( array( 'os' => 'GNU/Linux' ) );

				    echo sprintf( '<p>Linux: %u</p>', sizeof( $linux ) );
				?>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">
				Informações sobre dispositivos
			</div>
			<div class="panel-body">
				<?php 
				    $phone = $this->infos->getMany( array( 'is_mobile' => '1' ) );
				    $desktop = $this->infos->getMany( array( 'is_mobile' => '0' ) );

				    echo sprintf( '<p>Mobile: %u</p>', sizeof( $phone ) );
				    echo sprintf( '<p>Computador: %u</p>', sizeof( $desktop ) );
				?>
			</div>
		</div>


	</div>
</div>