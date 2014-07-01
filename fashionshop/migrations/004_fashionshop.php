<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Fashionshop extends CI_Migration
{

    public function up()
    {
        //For like and comment functions
        $this->_table_rate();
        $this->_table_customers();
    }

    public function down()
    {
        // Migration 1 has no rollback 
    }

    /**********************************************
     **                                           **
     **                                           **
     ** The following private methods are for     **
     ** checking the existence of and generating  **
     ** the base tables that GoCart operates on   **
     **                                           **
     **                                           **
     ***********************************************/

    /********************************************
     *
     * Generate like table
     *
     *********************************************/
    private function _table_rate()
    {
        if (!$this->db->table_exists('rate')) {
            $this->dbforge->add_field(array(
                'id' => array(
                    'type' => 'int',
                    'constraint' => 9,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'product_id' => array(
                    'type' => 'int',
                    'null' => false
                ),
                'user_id' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
                ),
                'rate' => array(
                    'type' => 'int',
                    'constraint' => 9,
                    'null' => true
                ),
                'content' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
                )
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('rate', true);
        }
    }

    /********************************************
     *
     * Regenerate customer table
     *
     *********************************************/
    private function _table_customers()
    {
        if (!$this->db->table_exists('customers')) {
            $this->dbforge->add_field(array(
                'id' => array(
                    'type' => 'int',
                    'constraint' => 9,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'firstname' => array(
                    'type' => 'varchar',
                    'constraint' => 32,
                    'null' => false
                ),
                'lastname' => array(
                    'type' => 'varchar',
                    'constraint' => 32,
                    'null' => false
                ),
                'email' => array(
                    'type' => 'varchar',
                    'constraint' => 128,
                    'null' => false
                ),
                'email_subscribe' => array(
                    'type' => 'tinyint',
                    'constraint' => 1,
                    'default' => '0'
                ),
                'phone' => array(
                    'type' => 'varchar',
                    'constraint' => 32,
                    'null' => false
                ),
                'company' => array(
                    'type' => 'varchar',
                    'constraint' => 128,
                    'null' => false
                ),
                'default_billing_address' => array(
                    'type' => 'int',
                    'constraint' => 9
                ),
                'default_shipping_address' => array(
                    'type' => 'int',
                    'constraint' => 9
                ),
                'ship_to_bill_address' => array(
                    'type' => 'enum',
                    'constraint' => array('false', 'true'),
                    'null' => false,
                    'default' => 'true'
                ),
                'password' => array(
                    'type' => 'varchar',
                    'constraint' => 40,
                    'null' => false
                ),
                'active' => array(
                    'type' => 'tinyint',
                    'constraint' => 1,
                    'null' => false
                ),
                'group_id' => array(
                    'type' => 'int',
                    'constraint' => 11,
                    'null' => false,
                    'default' => '1'
                ),
                'confirmed' => array(
                    'type' => 'tinyint',
                    'constraint' => 1,
                    'null' => false,
                    'default' => '0'
                ),
                'facebook' => array(
                    'type' => 'varchar',
                    'constraint' => 128,
                    'null' => true
                )
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('customers', true);
        }
    }
}