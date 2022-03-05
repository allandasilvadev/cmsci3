<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_views extends CI_Migration
{
	protected $table = 'views';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'post_type' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => ''
			),
			'post_type_hash' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'views' => array(
				'type' => 'int',
				'constraint' => 22,
				'null' => FALSE,
				'default' => 0
			),
			'hash' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
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