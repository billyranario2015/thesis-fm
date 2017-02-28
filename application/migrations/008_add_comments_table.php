<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Comments_Table extends CI_Migration {

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
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            /*
            | COMMENT TYPES
            | 1 = AREA      - ADD COMMENT TO AN AREA 
            | 2 = PARAMETER - ADD COMMENT TO A PARAMETER 
            | 3 = FILE      - ADD COMMENT TO A FILE
            */  
            'comment_type' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            /*
            | ID of a file | parameter | area
            */  
            'target_id' => array( 
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            'comment' => array(
                'type' => 'TEXT',
                'null' => true
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
        $this->dbforge->create_table('comments',TRUE); 

    }

    public function down()
    {
        $this->dbforge->drop_table('comments', TRUE);
    }
}