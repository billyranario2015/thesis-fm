<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Uploads_Table extends CI_Migration {

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
            'parameter_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            'author_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            'filename' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => true
            ),
            'tags' => array(
                'type' => 'TEXT',
                'null' => true
            ),
            /*
            | Sharing Status Codes
            | 1 = SHARE TO OTHER ORGANIZATIONS 
            | 2 = SHARE TO CURRENT ORGANIZATION ONLY 
            | 3 = ONLY YOUR COURSE CAN VIEW
            */ 
            'shared_status' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ),
            'is_trash' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
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
        $this->dbforge->create_table('uploads',TRUE); 

    }

    public function down()
    {
        $this->dbforge->drop_table('uploads', TRUE);
    }
}