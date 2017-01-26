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
                'constraint' => 255
            ),
            'organization_id' => array(
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
                'id'                => 1,
                'fname'             => 'Billy Joel',
                'mname'             => 'Loyola',
                'lname'             => 'Ranario',
                'user_level'        => 1,
                'role'              => 'Website Admin',
                'email'             => 'billy.ranario@must.edu.ph',
                'profile_image'     => 'avatar5.png',
                'password'          => sha1( 'blades200' ),
            ),
            array(
                'id'                => 2,
                'fname'             => 'Billy Joel',
                'mname'             => 'Loyola',
                'lname'             => 'Ranario',
                'user_level'        => 2,
                'role'              => 'Chairman',
                'email'             => 'billyranario@gmail.com',
                'profile_image'     => 'avatar5.png',
                'password'          => sha1( 'blades200' ),
            ),
        );
        $this->db->insert_batch('users', $data);

    }

  public function down()
  {
    $this->dbforge->drop_table('users', TRUE);
  }
}