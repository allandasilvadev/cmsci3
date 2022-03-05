<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_categorias extends CI_Migration
{
	protected $table = 'categorias';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 22,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'label' => array(
				'type' => 'varchar',
				'constraint' => 180,
				'null' => FALSE,
				'default' => ''
			),
			'slug' => array(
				'type' => 'varchar',
				'constraint' => 180,
				'null' => FALSE,
				'default' => ''
			),
			'description' => array(
				'type' => 'text',
				'null' => TRUE
			),
			'author' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'status' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => ''
			),
			'parent_category' => array(
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