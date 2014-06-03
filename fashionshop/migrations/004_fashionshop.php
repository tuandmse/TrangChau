<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Fashionshop extends CI_Migration {

    public function up()
    {
        //For like and comment functions
        $this->_table_like();
        $this->_table_comment();
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
    private function _table_like()
    {
        if(!$this->db->table_exists('like'))
        {
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
                )
            ));


            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('like', true);
        }
    }

    /********************************************
     *
     * Generate comment table
     *
     *********************************************/
    private function _table_comment()
    {
        if(!$this->db->table_exists('comment'))
        {
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
                'content' => array(
                    'type' => 'varchar',
                    'constraint' => 255,
                    'null' => false
                )
            ));

            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table('comment', true);
        }
    }
}