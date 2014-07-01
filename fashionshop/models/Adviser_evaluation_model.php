<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 6/25/14
 * Time: 12:05 AM
 */

class Adviser_evaluation_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view($data = array(), $return_count = false)
    {
        if (empty($data)) {
            return $this->db->get('adviser_evaluation')->result();
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
                return $this->db->count_all_results('adviser_evaluation');
            } else {
                return $this->db->get('adviser_evaluation')->result();
            }
        }
    }

    function save_adviser_evaluation($data)
    {
        $this->db->insert('adviser_evaluation', $data);
    }

    function view_details($id)
    {
        $this->db->where('evaluationId', $id);
        $result = $this->db->get('adviser_evaluation')->row();
        return $result;
    }

    function delete_adviser_evaluation($id)
    {
        $this->db->where('evaluationId', $id);
        $this->db->delete('adviser_evaluation');
    }
}