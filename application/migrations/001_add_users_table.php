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
                'constraint' => 150
            ),
            'mname' => array(
                'type' => 'VARCHAR',
                'constraint' => 150
            ),
            'lname' => array(
                'type' => 'VARCHAR',
                'constraint' => 150
            ),
            'user_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'account_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'profile_image' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
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
                'user_type'         => 'Superadmin',
                'account_type'      => 'Website Admin',
                'email'             => 'billy.ranario@must.edu.ph',
                'profile_image'     => 'avatar5.png',
                'password'          => sha1( 'blades200' ),
            ),
            array(
                'id'                => 2,
                'fname'             => 'Billy Joel',
                'mname'             => 'Loyola',
                'lname'             => 'Ranario',
                'user_type'         => 'Superadmin',
                'account_type'      => 'Chairman',
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