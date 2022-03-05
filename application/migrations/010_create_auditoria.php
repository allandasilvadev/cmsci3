<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_auditoria extends CI_Migration
{
	protected $table = 'auditoria';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'query' => array(
				'type' => 'text',
				'null' => TRUE
			),
			'author' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'label' => array(
				'type' => 'varchar',
				'constraint' => 180,
				'null' => FALSE,
				'default' => ''
			),
			'description' => array(
				'type' => 'text',
				'null' => TRUE
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