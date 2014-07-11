<?php
/**
 * Created by PhpStorm.
 * User: Trang Chau
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Adviser_question_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view($data = array(), $return_count = false)
    {
        if (empty($data)) {
            return $this->db->get('adviser_question')->result();
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
                return $this->db->count_all_results('adviser_question');
            } else {
                return $this->db->get('adviser_question')->result();
            }
        }
    }

    function save_adviser_question($data)
    {
        $this->db->where('questionNode', $data['questionNode']);
        $result = $this->db->get('adviser_question');
        $question = $result->row();
        if (count($question) < 1) {
            $this->db->insert('adviser_question', $data);
            $this->db->order_by("questionNode", "desc");
            $question = $this->db->get('adviser_question')->row();
            return $question->questionNode;
        } else {
            $this->db->where('questionNode', $data['questionNode']);
            $this->db->update('adviser_question', $data);
            return $data['questionNode'];
        }
    }

    function save_adviser_question_answer($data)
    {
        $this->db->where('nodesNode', $data['nodesNode']);
        $result = $this->db->get('adviser_nodes');
        $question = $result->row();
        if (count($question) < 1) {
            $this->db->insert('adviser_nodes', $data);
        } else {
            $this->db->where('nodesNode', $data['nodesNode']);
            $this->db->update('adviser_nodes', $data);
        }
    }

    function viewdetails($id)
    {
        $this->db->where('questionNode', $id);
        $result = $this->db->get('adviser_question');
        $question = $result->row();
        return $question;
    }

    function question_answer($id)
    {
        $this->db->where('questionNode', $id);
        $result = $this->db->get('adviser_nodes');
        return $result->result();
    }

    function delete($id)
    {
        $this->db->where('questionNode', $id);
        $this->db->delete('adviser_question');
    }
}