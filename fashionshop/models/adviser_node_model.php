<?php
/**
 * Created by PhpStorm.
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Adviser_node_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view() 	{
        $this->db->order_by("nodesNode", "desc");
        return $this->db->get('adviser_nodes')->result();
    }

    function save_adviser_node($data)
    {
        $this->db->where('nodesNode', $data['nodesNode']);
        $result 			= $this->db->get('adviser_nodes');
        $question				= $result->row();
        if(count($question) < 1)
        {
            $this->db->insert('adviser_nodes', $data);
        }
        else
        {
            $this->db->where('nodesNode', $data['nodesNode']);
            $this->db->update('adviser_nodes', $data);
        }
    }

    function save_adviser_question_answer($data, $questionNode)
    {
        $this->db->where('nodesNode', $data['nodesNode']);
        $result 			= $this->db->get('adviser_nodes');
        $question				= $result->row();
        if(count($question) < 1)
        {
            $this->db->insert('adviser_nodes', $data);
        }
        else
        {
            $this->db->where('nodesNode', $data['nodesNode']);
            $this->db->update('adviser_nodes', $data);
        }
    }

    function viewdetails($id ) 	{
        $this->db->where('nodesNode', $id);
        $result 			= $this->db->get('adviser_nodes');
        $question				= $result->row();
        return $question;
    }

    function question_answer($id) {
        $this->db->where('questionNode', $id);
        $result 			= $this->db->get('adviser_nodes');
        return $result->result();
    }

    function delete($id)
    {
        $this->db->where('nodesNode', $id);
        $this->db->delete('adviser_nodes');
    }
}