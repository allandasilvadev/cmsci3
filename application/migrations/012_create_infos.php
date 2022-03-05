<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_infos extends CI_Migration
{
	protected $table = 'infos';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'navigator' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => FALSE,
				'default' => ''
			),
			'navigator_version' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => FALSE,
				'default' => ''
			),
			'os' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => FALSE,
				'default' => ''
			),
			'os_arch' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => FALSE,
				'default' => ''
			),
			'is_mobile' => array(
				'type' => 'boolean',
				'null' => FALSE,
				'default' => FALSE
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