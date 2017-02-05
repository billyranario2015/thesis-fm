<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Organizations_Table extends CI_Migration {

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
            'organization_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        // $this->dbforge->create_table('organization',TRUE); 

        // Defaults
        $data = array(
            array(
                'id'                => 1,
                'organization_name' => 'CIIT',
            ),
            array(
                'id'                => 2,
                'organization_name' => 'CEA',
            ),
            array(
                'id'                => 3,
                'organization_name' => 'CPSEM',
            ),
            array(
                'id'                => 4,
                'organization_name' => 'CAS',
            ),
        );
        // $this->db->insert_batch('organization', $data);

    }

  public function down()
  {
    // $this->dbforge->drop_table('organization', TRUE);
  }
}