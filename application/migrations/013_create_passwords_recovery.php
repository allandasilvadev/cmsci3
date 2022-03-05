<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_passwords_recovery extends CI_Migration
{
	protected $table = 'passwords_recovery';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'address' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'hash' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'expiration datetime not null default current_timestamp',
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