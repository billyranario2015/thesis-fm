<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Logs_Table extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'course_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true 
            ),
            'author_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true 
            ),
            'message' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'link' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('logs',TRUE); 

    }

  public function down()
  {
    $this->dbforge->drop_table('logs', TRUE);
  }
}