<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_posts extends CI_Migration
{
	protected $table = 'posts';

	public function up()
	{
		$this->dbforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'avatar' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => TRUE
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
			'status' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => 'published'
			),
			'visibility' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => 'private'
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
			'hash' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'published_at datetime default null',
			'expiration_at datetime default null',
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