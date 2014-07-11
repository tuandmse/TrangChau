<?php
/**
 * Created by PhpStorm.
 * User: Trang Chau
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Adviser_rule_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view($data = array(), $return_count = false)
    {
        if (empty($data)) {
            return $this->db->get('adviser_rules')->result();
        } else {

            if (!empty($data['rows'])) {
                $this->db->limit($data['rows']);
            }

            if (!empty($data['page'])) {
                $this->db->offset($data['page']);
            }

            if (!empty($data['order_by'])) {
                $this->db->order_by($data['order_by'], $data['sort_order']);
            }

            if ($return_count) {
                return $this->db->count_all_results('adviser_rules');
            } else {
                return $this->db->get('adviser_rules')->result();
            }
        }
    }

    function list_lefthand()
    {
        $this->db->where('questionNode is not null and questionNode!=\'\'', null, false);
        return $this->db->get('adviser_nodes')->result();
    }

    function list_righthand()
    {
        $this->db->where('questionNode is null or questionNode=\'\'', null, false);
        return $this->db->get('adviser_nodes')->result();
    }

    function save_adviser_rule($data)
    {
        $this->db->where('rulesId', $data['rulesId']);
        $result = $this->db->get('adviser_rules');
        $question = $result->row();
        if (count($question) < 1) {
            $this->db->insert('adviser_rules', $data);
        } else {
            $this->db->where('rulesId', $data['rulesId']);
            $this->db->update('adviser_rules', $data);
        }
    }

    function get_adviser_by_content($content)
    {
        $this->db->where('rulesContent', $content);
        $result = $this->db->get('adviser_rules');
        return $result->result();
    }


    function viewdetails($id)
    {
        $this->db->where('rulesId', $id);
        $result = $this->db->get('adviser_rules');
        $question = $result->row();
        return $question;
    }

    function delete($id)
    {
        $this->db->where('rulesId', $id);
        $this->db->delete('adviser_rules');
    }
}