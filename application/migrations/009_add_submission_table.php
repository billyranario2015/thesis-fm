<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Submission_Table extends CI_Migration {

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
            'organization_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            'course_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            /*
            | SUBMISSION TYPES
            | 1 = SUBMIT AREA TO CHAIRMAN 
            | 2 = SUBMIT TO IN-HOUSE EVALUATOR 
            */
            'submission_type' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),
            /*
            | SUBMISSION STATUS
            | 1 = APPROVED 
            | 2 = NEED TO REVISE
            | 3 = UNAPPROVED 
            */  
            'submission_status' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 3
            ),
            /*
            | AREA SUBMISSION
            | ONLY IF SUBMISSION TYPE == 1
            */   
            'area_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ),  
            'level_id' => array(
                'type' => 'INT',
                'constraint' => 11,
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
        $this->dbforge->create_table('submission',TRUE); 

    }

    public function down()
    {
        $this->dbforge->drop_table('submission', TRUE);
    }
}