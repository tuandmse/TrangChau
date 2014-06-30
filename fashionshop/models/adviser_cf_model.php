<?php
/**
 * Created by PhpStorm.
 * User: Ce No
 * Date: 5/23/14
 * Time: 8:04 PM
 */

class Adviser_cf_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view()
    {
        $this->db->order_by("cfId", "desc");
        return $this->db->get('adviser_cf')->result();
    }

    function save_adviser_cf($data)
    {
        $this->db->where('cfId', $data['cfId']);
        $result = $this->db->get('adviser_cf');
        $question = $result->row();
        if (count($question) < 1) {
            $this->db->insert('adviser_cf', $data);
        } else {
            $this->db->where('cfId', $data['cfId']);
            $this->db->update('adviser_cf', $data);
        }
    }

    function viewdetails($id)
    {
        $this->db->where('cfId', $id);
        $result = $this->db->get('adviser_cf');
        $question = $result->row();
        return $question;
    }

    function delete($id)
    {
        $this->db->where('cfId', $id);
        $this->db->delete('adviser_cf');
    }
}