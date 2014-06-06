<?php
/**
 * Created by PhpStorm.
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Adviser_question_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view() 	{
        $this->db->order_by("questionNode", "desc");
        return $this->db->get('adviser_question')->result();
    }

    function insert( $data = array() ) {
        $data["name"] = $this->db->escape_str($data["name"]);
        $data["email"] = $this->db->escape_str($data["email"]);
        $data["content"] = $this->db->escape_str($data["content"]);
        $data["title"] = $this->db->escape_str($data["title"]);
        $data["name"] = htmlspecialchars( $data["name"] );
        $data["email"] = htmlspecialchars( $data["email"] );
        $data["title"] = htmlspecialchars( $data["title"] );
        $data["content"] = htmlspecialchars( $data["content"] );
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO fs_guestbook (guestbook_id,name,email,title,datetime,content) VALUES ('null','". $data["name"] ."','". $data["email"] ."','". $data["title"] ."','$datetime','". $data["content"] ."')";
        return $this->db->query( $sql );
    }

    function save_adviser_question($data)
    {
        $this->db->where('questionNode', $data['questionNode']);
        $result 			= $this->db->get('adviser_question');
        $question				= $result->row();
        if(count($question) < 1)
        {
            $this->db->insert('adviser_question', $data);
            $this->db->order_by("questionNode", "desc");
            $question = $this->db->get('adviser_question')->row();
            return $question->questionNode;
        }
        else
        {
            $this->db->where('questionNode', $data['questionNode']);
            $this->db->update('adviser_question', $data);
            return $data['questionNode'];
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
        $this->db->where('questionNode', $id);
        $result 			= $this->db->get('adviser_question');
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
        $this->db->where('questionNode', $id);
        $this->db->delete('adviser_question');
    }
}