<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_paginas extends CI_Migration
{
	protected $table = 'paginas';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
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
			'_order' => array(
				'type' => 'int',
				'constraint' => 22,
				'null' => FALSE,
				'default' => 0
			),
			'status' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => 'no-published'
			),
			'author' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'body' => array(
				'type' => 'text',
				'null' => TRUE
			),
			'isHome' => array(
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