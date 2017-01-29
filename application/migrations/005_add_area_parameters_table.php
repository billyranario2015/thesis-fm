<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Parameters_Table extends CI_Migration {

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
            'area_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0 // for unassigned value
            ),
            'parameter_name' => array(
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
        $this->dbforge->create_table('area_parameters',TRUE); 

    }

  public function down()
  {
    $this->dbforge->drop_table('area_parameters', TRUE);
  }
}