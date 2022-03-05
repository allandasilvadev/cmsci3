<?php

if ( ! defined( 'BASEPATH' ) ) {
	exit;
}

class Migration_Change_midias extends CI_Migration
{
	protected $table = 'midias';

	public function up()
	{
		$fields = array(
			'legenda' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => FALSE,
				'default' => ''
			)
		);
		$this->dbforge->add_column( $this->table, $fields, 'id' );

		$fields = array(
			'visibilidade' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => 'private'
			)
		);
		$this->dbforge->add_column( $this->table, $fields, 'legenda' );

		$fields = array(
			'status' => array(
				'type' => 'varchar',
				'constraint' => 80,
				'null' => FALSE,
				'default' => 'no-published'
			)
		);
		$this->dbforge->add_column( $this->table, $fields, 'visibilidade' );

		$fields = array(
			'description' => array(
				'type' => 'text',
				'null' => TRUE
			)
		);

		$this->dbforge->add_column( $this->table, $fields, 'status' );
	}

	public function down()
	{
		$this->dbforge->drop_column( $this->table, 'legenda' );
		$this->dbforge->drop_column( $this->table, 'visibilidade' );
		$this->dbforge->drop_column( $this->table, 'status' );
		$this->dbforge->drop_column( $this->table, 'description' );
	}
}