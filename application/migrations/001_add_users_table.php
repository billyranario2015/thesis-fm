<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Users_Table extends CI_Migration {

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
            'fname' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'default' => 'John'
            ),
            'mname' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'default' => 'Don'
            ),
            'lname' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'default' => 'Doe'
            ),
            // user_levels = [ 
            //  1 => 'Superadmin'
            //  2 => 'Admin'
            //  5 => 'Over All Chairman'
            //  3 => 'User'
            //  4 => 'Guest'
            // ]
            'user_level' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default'   => 3,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'profile_image' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => 'avatar5.png'
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
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
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
        $this->dbforge->create_table('users',TRUE); 

        // Default Account
        $data = array(
            array(
                'fname'             => 'Admin',
                'mname'             => 'User',
                'lname'             => 'Account',
                'user_level'        => 1,
                'role'              => 'Website Admin',
                'organization_id'   => null,
                'course_id'         => null,
                'email'             => 'admin@must.edu.ph',
                'password'          => sha1( '123' ),
            ),
            array(
                'fname'             => 'Jane',
                'mname'             => 'Smith',
                'lname'             => 'Doe',
                'user_level'        => 2,
                'role'              => 'Admin',
                'organization_id'   => 1,
                'course_id'         => 1,
                'email'             => 'jane@doe.com',
                'password'          => sha1( '123' ),
            ),
            array(
                'fname'             => 'Jane',
                'mname'             => 'Smith',
                'lname'             => 'Doe',
                'user_level'        => 5,
                'role'              => 'Overall Chairman',
                'organization_id'   => 1,
                'course_id'         => 1,
                'email'             => 'over@gmail.com',
                'password'          => sha1( '123' ),
            ),
            array(
                'fname'             => 'John',
                'mname'             => 'Smith',
                'lname'             => 'Doe',
                'user_level'        => 3,
                'role'              => 'Sub Chairman',
                'organization_id'   => 1,
                'course_id'         => 1,
                'email'             => 'john@doe.com',
                'password'          => sha1( '123' ),
            ),
            array(
                'fname'             => 'Jonathan',
                'mname'             => 'Smith',
                'lname'             => 'Doe',
                'user_level'        => 4,
                'role'              => 'In-House Evaluator',
                'organization_id'   => 1,
                'course_id'         => 1,
                'email'             => 'jonathan@doe.com',
                'password'          => sha1( '123' ),
            ),
        );
        $this->db->insert_batch('users', $data);

    }

  public function down()
  {
    $this->dbforge->drop_table('users', TRUE);
  }
}