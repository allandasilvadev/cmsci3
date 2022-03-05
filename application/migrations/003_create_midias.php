<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_midias extends CI_Migration
{
	protected $table = 'midias';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'hash' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'uri' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'type' => array(
				'type' => 'varchar',
				'constraint' => 60,
				'null' => FALSE,
				'default' => ''
			),
			'author' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'extension' => array(
				'type' => 'varchar',
				'constraint' => 40,
				'null' => FALSE,
				'default' => ''
			),
			'size' => array(
				'type' => 'decimal',
				'constraint' => '10,2',
				'null' => FALSE,
				'default' => 0
			),
			'is_image' => array(
				'type' => 'boolean',
				'null' => FALSE,
				'default' => TRUE
			),
			'image_width' => array(
				'type' => 'int',
				'constraint' => 20,
				'null' => FALSE,
				'default' => 0
			),
			'image_height' => array(
				'type' => 'int',
				'constraint' => 20,
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