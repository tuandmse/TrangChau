<?php
/**
 * Created by PhpStorm.
 * User: Ce No
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

    function view()
    {
        $this->db->order_by("rulesId", "desc");
        return $this->db->get('adviser_rules')->result();
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