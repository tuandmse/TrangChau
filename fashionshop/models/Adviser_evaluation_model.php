<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 6/25/14
 * Time: 12:05 AM
 */

class Adviser_evaluation_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function view() 	{
        $this->db->order_by("evaluationId", "desc");
        return $this->db->get('adviser_evaluation')->result();
    }

    function save_adviser_evaluation($data)
    {
      
    }

    function viewdetails($id ) 	{
        $this->db->where('evaluationId', $id);
        $result 			= $this->db->get('adviser_evaluation')->row();
        return $result;
    }

    function delete($id)
    {
        $this->db->where('evaluationId', $id);
        $this->db->delete('adviser_evaluation');
    }
}