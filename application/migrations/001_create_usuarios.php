<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_usuarios extends CI_Migration
{
	protected $table = 'usuarios';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'nome' => array(
				'type' => 'varchar',
				'constraint' => 180,
				'null' => FALSE,
				'default' => ''
			),
			'login' => array(
				'type' => 'varchar',
				'constraint' => 160,
				'null' => FALSE,
				'default' => ''
			),
			'email' => array(
				'type' => 'varchar',
				'constraint' => 180,
				'null' => FALSE,
				'default' => ''
			),
			'senha' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'avatar' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'sobre' => array(
				'type' => 'text',
				'null' => TRUE
			),
			'nivel' => array(
				'type' => 'int',
				'constraint' => 12,
				'null' => FALSE,
				'default' => 2
			),
			'status' => array(
				'type' => 'int',
				'constraint' => 12,
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