<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Create_messages extends CI_Migration
{
	protected $table = 'messages';
	protected $second;
	protected $secondforge;

	public function __construct()
	{
		parent::__construct();
		$this->second = $this->load->database( 'second', TRUE );
		$this->secondforge = $this->load->dbforge( $this->second, TRUE );
	}

	public function up()
	{
		$this->secondforge->add_field( array(
			'id' => array(
				'type' => 'int',
				'constraint' => 12,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'author' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			),
			'label' => array(
				'type' => 'varchar',
				'constraint' => 120,
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
			'created_at datetime default current_timestamp',
			'updated_at datetime default null',
			'deleted_at datetime default null'
		) );
		$this->secondforge->add_key( 'id', TRUE );
		$this->secondforge->create_table( $this->table );
	}

	public function down()
	{
		$this->secondforge->drop_table( $this->table );
	}

}