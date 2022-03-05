<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_posts_categorias extends CI_Migration
{
	protected $table = 'posts_categorias';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'posts_id' => array(
				'type' => 'int',
				'constraint' => 22,
				'null' => FALSE,
				'default' => 0
			),
			'categorias_id' => array(
				'type' => 'int',
				'constraint' => 22,
				'null' => FALSE,
				'default' => 0
			),
			'created_at datetime default current_timestamp',
			'updated_at datetime default null',
			'deleted_at datetime default null'
		) );
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( $this->table );
	}

	public function down()
	{
		$this->dbforge->drop_table( $this->table );
	}
}